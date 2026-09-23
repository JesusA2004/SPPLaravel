<?php

namespace App\Support;

/**
 * Metadatos SEO de una página. Se comparten con Inertia y se imprimen
 * también en la plantilla Blade para que los buscadores los lean sin JS.
 */
class Seo
{
    public const HOME_TITLE = 'Servicios de Protección Profesional | SPP Seguridad Privada en Morelos';

    public const HOME_DESCRIPTION = 'Servicios de Protección Profesional (SPP), empresa de seguridad privada en Cuernavaca, Morelos, con más de 20 años de experiencia: guardias de seguridad intramuros, escoltas, instalación de CCTV y cercas eléctricas.';

    /**
     * @return array{title: string|null, fullTitle: string, description: string, canonical: string, image: string, type: string}
     */
    public static function make(?string $title = null, ?string $description = null, ?string $image = null, string $type = 'website'): array
    {
        return [
            'title' => $title,
            'fullTitle' => $title ? "{$title} | ".config('spp.name') : self::HOME_TITLE,
            'description' => $description ?? self::HOME_DESCRIPTION,
            'canonical' => url()->current(),
            'image' => url($image ?? '/images/marca/og-image.jpg'),
            'type' => $type,
        ];
    }

    /**
     * Datos estructurados (schema.org) de la empresa para buscadores.
     *
     * @return array<string, mixed>
     */
    public static function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => url('/').'#empresa',
            'name' => config('spp.name'),
            'alternateName' => [config('spp.short_name'), 'SPP Seguridad Privada'],
            'legalName' => config('spp.legal_name'),
            'description' => self::HOME_DESCRIPTION,
            'url' => url('/'),
            'logo' => url('/images/marca/logo-grande.webp'),
            'image' => url('/images/marca/og-image.jpg'),
            'telephone' => '+52 '.config('spp.contact.phone.label'),
            'email' => config('spp.contact.email'),
            'taxID' => 'SPP020301HV1',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => config('spp.contact.address'),
                'addressLocality' => 'Cuernavaca',
                'addressRegion' => 'Morelos',
                'addressCountry' => 'MX',
            ],
            'areaServed' => 'Morelos, México',
            'hasMap' => config('spp.contact.maps_url'),
            'sameAs' => array_column(config('spp.social'), 'url'),
            'makesOffer' => array_map(fn (array $service) => [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => $service['name'],
                    'description' => $service['summary'],
                    'url' => url($service['url']),
                ],
            ], ServiceCatalog::summaries()),
        ];
    }
}
