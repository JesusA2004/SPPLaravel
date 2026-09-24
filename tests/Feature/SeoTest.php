<?php

use App\Support\ServiceCatalog;

beforeEach(function () {
    config(['app.url' => 'https://seguridadprivadaspp.com']);
});

/**
 * @return array<string, mixed>
 */
function jsonLd(string $html): array
{
    preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);

    return json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);
}

/**
 * @param  array<string, mixed>  $schema
 * @return list<string>
 */
function schemaTypes(array $schema): array
{
    return array_column($schema['@graph'], '@type');
}

test('la página de inicio tiene título, descripción y metadatos sociales', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="es-MX">', false)
        ->assertSee('<title data-inertia="">SPP Seguridad Privada en Cuernavaca, Morelos | Servicios de Protección Profesional</title>', false)
        ->assertSee('name="description" content="SPP, empresa de seguridad privada en Cuernavaca, Morelos', false)
        ->assertSee('<link data-inertia="canonical" rel="canonical" href="https://seguridadprivadaspp.com/">', false)
        ->assertSee('property="og:image" content="https://seguridadprivadaspp.com/images/marca/spp-social-2026.jpg"', false)
        ->assertSee('property="og:image:width" content="1200"', false)
        ->assertSee('property="og:image:height" content="630"', false)
        ->assertSee('name="twitter:card" content="summary_large_image"', false)
        ->assertSee('property="og:description" content="SPP, empresa de seguridad privada en Cuernavaca, Morelos, con más de 20 años de experiencia. Guardias intramuros, escoltas, CCTV y cercas eléctricas. Cotiza sin compromiso al 777 102 26 76 o por WhatsApp."', false)
        ->assertSee('name="robots" content="index, follow, max-image-preview:large"', false);
});

test('el canonical usa APP_URL aunque la petición llegue por otro host', function () {
    $this->get('http://127.0.0.1/servicios/escolta')
        ->assertOk()
        ->assertSee('rel="canonical" href="https://seguridadprivadaspp.com/servicios/escolta"', false)
        ->assertSee('property="og:url" content="https://seguridadprivadaspp.com/servicios/escolta"', false)
        ->assertDontSee('content="http://127.0.0.1', false)
        ->assertDontSee('href="http://127.0.0.1/servicios', false);
});

test('la página de inicio publica la empresa y el sitio en schema.org', function () {
    $schema = jsonLd($this->get('/')->getContent());
    $organization = collect($schema['@graph'])->firstWhere('@type', 'ProfessionalService');

    expect(schemaTypes($schema))->toContain('ProfessionalService', 'WebSite', 'WebPage')
        ->and($organization['name'])->toBe('Servicios de Protección Profesional')
        ->and($organization['alternateName'])->toContain('SPP')
        ->and($organization['telephone'])->toBe('+52 777 102 26 76')
        ->and($organization['address']['streetAddress'])->toBe('Av. Lomas del Tzompantle 200')
        ->and($organization['address']['addressLocality'])->toBe('Cuernavaca')
        ->and($organization)->not->toHaveKey('aggregateRating');
});

test('cada servicio tiene su título, canonical y esquemas Service y BreadcrumbList', function (string $slug) {
    $service = ServiceCatalog::find($slug);
    $response = $this->get("/servicios/{$slug}")->assertOk();

    $response
        ->assertSee('<title data-inertia="">'.e($service['seoTitle']).'</title>', false)
        ->assertSee('content="'.e($service['seoDescription']).'"', false)
        ->assertSee("https://seguridadprivadaspp.com/servicios/{$slug}", false)
        ->assertSee('https://seguridadprivadaspp.com'.$service['ogImage'], false);

    $schema = jsonLd($response->getContent());
    $graph = collect($schema['@graph']);

    expect(schemaTypes($schema))->toContain('Service', 'BreadcrumbList')
        ->and($graph->firstWhere('@type', 'Service')['provider']['@id'])->toBe('https://seguridadprivadaspp.com/#organizacion')
        ->and($graph->firstWhere('@type', 'BreadcrumbList')['itemListElement'])->toHaveCount(3);
})->with(ServiceCatalog::slugs());

test('el sitemap es XML válido e incluye todas las páginas públicas', function () {
    $response = $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

    $xml = simplexml_load_string($response->getContent());
    $urls = array_map('strval', $xml->xpath('//*[local-name()="loc"]'));

    expect($urls)->toEqual([
        'https://seguridadprivadaspp.com/',
        'https://seguridadprivadaspp.com/servicios',
        ...array_map(fn (string $slug) => "https://seguridadprivadaspp.com/servicios/{$slug}", ServiceCatalog::slugs()),
    ]);

    expect(array_map('strval', $xml->xpath('//*[local-name()="lastmod"]')))
        ->each->toBe(config('spp.seo.updated_at'));
});

test('robots.txt permite el rastreo y apunta al sitemap', function () {
    $response = $this->get('/robots.txt')->assertOk();

    expect($response->headers->get('Content-Type'))->toStartWith('text/plain')
        ->and($response->getContent())->toBe("User-agent: *\nAllow: /\n\nSitemap: https://seguridadprivadaspp.com/sitemap.xml\n");
});

test('si APP_URL quedó en localhost se usa el dominio real de la visita', function (string $requestUrl) {
    config(['app.url' => 'http://localhost:8000']);

    $response = $this->get($requestUrl)->assertOk();

    $response
        ->assertSee('rel="canonical" href="https://seguridadprivadaspp.com/"', false)
        ->assertSee('property="og:image" content="https://seguridadprivadaspp.com/images/marca/spp-social-2026.jpg"', false)
        ->assertSee('name="twitter:image" content="https://seguridadprivadaspp.com/images/marca/spp-social-2026.jpg"', false)
        ->assertDontSee('localhost:8000', false);

    $this->get($requestUrl.'robots.txt')
        ->assertSee('Sitemap: https://seguridadprivadaspp.com/sitemap.xml');
})->with(['https://seguridadprivadaspp.com/', 'https://www.seguridadprivadaspp.com/']);

test('en local se conserva APP_URL', function () {
    config(['app.url' => 'http://localhost:8000']);

    $this->get('http://localhost:8000/')
        ->assertSee('rel="canonical" href="http://localhost:8000/"', false);
});
