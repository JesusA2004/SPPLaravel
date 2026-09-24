<?php

namespace App\Support;

/**
 * Metadatos SEO de una página. Se comparten con Inertia y se imprimen
 * también en la plantilla Blade para que los buscadores los lean sin JS.
 */
class Seo
{
    private const OG_IMAGE = '/images/marca/spp-social-2026-v2.jpg';

    private const OG_IMAGE_WIDTH = 1200;

    private const OG_IMAGE_HEIGHT = 630;

    /**
     * @param  list<array{name: string, url: string}>  $breadcrumbs  Migas después de "Inicio".
     * @param  array<string, mixed>|null  $service  Servicio del catálogo para su esquema Service.
     * @return array{title: string, description: string, socialDescription: string, canonical: string, image: string, imageWidth: int, imageHeight: int, imageAlt: string, type: string, robots: string, schema: array<string, mixed>}
     */
    public static function make(
        string $title,
        string $description,
        ?string $image = null,
        array $breadcrumbs = [],
        ?array $service = null,
        bool $indexable = true,
    ): array {
        $canonical = self::absoluteUrl(request()->path());

        return [
            'title' => $title,
            'description' => $description,
            'socialDescription' => $description.' Cotiza sin compromiso al '.config('spp.contact.phone.label').' o por WhatsApp.',
            'canonical' => $canonical,
            'image' => self::absoluteUrl($image ?? self::OG_IMAGE),
            'imageWidth' => self::OG_IMAGE_WIDTH,
            'imageHeight' => self::OG_IMAGE_HEIGHT,
            'imageAlt' => $title,
            'type' => 'website',
            'robots' => $indexable ? 'index, follow, max-image-preview:large' : 'noindex, follow',
            'schema' => self::graph($title, $description, $canonical, $breadcrumbs, $service),
        ];
    }

    /**
     * URL absoluta sobre el dominio canónico (ver baseUrl()).
     */
    public static function absoluteUrl(string $path = '/'): string
    {
        $path = trim($path, '/');

        return self::baseUrl().($path === '' ? '/' : '/'.$path);
    }

    /**
     * Dominio canónico: APP_URL cuando apunta a un dominio público. Si quedó
     * con un valor local (localhost, 127.0.0.1…), se usa el dominio de la
     * petición sin "www" para que canonical, Open Graph y sitemap nunca
     * anuncien una dirección inaccesible para buscadores y redes sociales.
     */
    public static function baseUrl(): string
    {
        $configured = rtrim((string) config('app.url'), '/');

        if (! self::isLocalUrl($configured) || (app()->runningInConsole() && ! app()->runningUnitTests())) {
            return $configured;
        }

        $request = request();
        $host = preg_replace('/^www\./i', '', $request->getHost());

        if (self::isLocalUrl('http://'.$host)) {
            return $configured;
        }

        if ($request->isSecure() || app()->isProduction()) {
            return 'https://'.$host;
        }

        return $request->getSchemeAndHttpHost() === $request->getScheme().'://'.$request->getHost()
            ? $request->getScheme().'://'.$host
            : $request->getScheme().'://'.$host.':'.$request->getPort();
    }

    public static function isLocalUrl(string $url): bool
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));

        return $host === ''
            || in_array($host, ['localhost', '127.0.0.1', '::1', '[::1]', '0.0.0.0'], true)
            || str_ends_with($host, '.localhost')
            || str_ends_with($host, '.test');
    }

    /**
     * @param  list<array{name: string, url: string}>  $breadcrumbs
     * @param  array<string, mixed>|null  $service
     * @return array<string, mixed>
     */
    private static function graph(string $title, string $description, string $canonical, array $breadcrumbs, ?array $service): array
    {
        $home = self::absoluteUrl();
        $organizationId = $home.'#organizacion';

        $webPage = [
            '@type' => 'WebPage',
            '@id' => $canonical.'#pagina',
            'url' => $canonical,
            'name' => $title,
            'description' => $description,
            'socialDescription' => $description.' Cotiza sin compromiso al '.config('spp.contact.phone.label').' o por WhatsApp.',
            'inLanguage' => 'es-MX',
            'isPartOf' => ['@id' => $home.'#sitio'],
            'about' => ['@id' => $organizationId],
        ];

        $graph = [self::organization($organizationId), self::website($home, $organizationId)];

        if ($breadcrumbs !== []) {
            $webPage['breadcrumb'] = ['@id' => $canonical.'#migas'];
            $graph[] = self::breadcrumbList($canonical, $breadcrumbs);
        }

        if ($service !== null) {
            $webPage['mainEntity'] = ['@id' => $canonical.'#servicio'];
            $graph[] = self::service($canonical, $service, $organizationId);
        }

        $graph[] = $webPage;

        return ['@context' => 'https://schema.org', '@graph' => $graph];
    }

    /**
     * @return array<string, mixed>
     */
    private static function organization(string $id): array
    {
        $contact = config('spp.contact');

        return [
            '@type' => 'ProfessionalService',
            '@id' => $id,
            'name' => config('spp.name'),
            'alternateName' => [config('spp.short_name'), 'SPP Seguridad Privada'],
            'legalName' => config('spp.legal_name'),
            'description' => config('spp.description'),
            'url' => self::absoluteUrl(),
            'logo' => self::absoluteUrl('/images/marca/logo-grande.webp'),
            'image' => self::absoluteUrl(self::OG_IMAGE),
            'telephone' => '+52 '.$contact['phone']['label'],
            'email' => $contact['email'],
            'taxID' => config('spp.rfc'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $contact['address'],
                'addressLocality' => $contact['locality'],
                'addressRegion' => $contact['region'],
                'addressCountry' => $contact['country'],
            ],
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $contact['geo']['latitude'],
                'longitude' => $contact['geo']['longitude'],
            ],
            'hasMap' => $contact['maps_url'],
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Cuernavaca'],
                ['@type' => 'State', 'name' => 'Morelos'],
            ],
            'knowsAbout' => ['Seguridad privada', 'Guardias de seguridad', 'Escoltas', 'Videovigilancia CCTV', 'Cercas eléctricas'],
            'sameAs' => array_column(config('spp.social'), 'url'),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '+52 '.$contact['phone']['label'],
                'email' => $contact['email'],
                'contactType' => 'customer service',
                'areaServed' => 'MX',
                'availableLanguage' => 'es',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function website(string $home, string $organizationId): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => $home.'#sitio',
            'url' => $home,
            'name' => config('spp.name'),
            'alternateName' => config('spp.short_name'),
            'inLanguage' => 'es-MX',
            'publisher' => ['@id' => $organizationId],
        ];
    }

    /**
     * @param  list<array{name: string, url: string}>  $breadcrumbs
     * @return array<string, mixed>
     */
    private static function breadcrumbList(string $canonical, array $breadcrumbs): array
    {
        $items = [['name' => 'Inicio', 'url' => '/'], ...$breadcrumbs];

        return [
            '@type' => 'BreadcrumbList',
            '@id' => $canonical.'#migas',
            'itemListElement' => array_map(fn (array $item, int $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => self::absoluteUrl($item['url']),
            ], $items, array_keys($items)),
        ];
    }

    /**
     * @param  array<string, mixed>  $service
     * @return array<string, mixed>
     */
    private static function service(string $canonical, array $service, string $organizationId): array
    {
        return [
            '@type' => 'Service',
            '@id' => $canonical.'#servicio',
            'name' => $service['name'],
            'serviceType' => $service['serviceType'],
            'description' => implode(' ', $service['overview']),
            'url' => $canonical,
            'image' => self::absoluteUrl($service['heroImage']['src']),
            'provider' => ['@id' => $organizationId],
            'areaServed' => $service['coverage'],
            'audience' => [
                '@type' => 'Audience',
                'audienceType' => implode(', ', $service['audience']),
            ],
        ];
    }
}
