<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use App\Support\ServiceCatalog;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $paths = [
            '/',
            route('services.index', absolute: false),
            ...array_map(fn (string $slug) => route('services.show', $slug, false), ServiceCatalog::slugs()),
        ];

        return response()
            ->view('seo.sitemap', [
                'urls' => array_map(Seo::absoluteUrl(...), $paths),
                'lastModified' => config('spp.seo.updated_at'),
            ])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Sitemap: '.Seo::absoluteUrl('sitemap.xml'),
            '',
        ]);

        return response($content)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
