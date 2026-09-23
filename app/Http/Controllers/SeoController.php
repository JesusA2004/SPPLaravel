<?php

namespace App\Http\Controllers;

use App\Support\ServiceCatalog;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $urls = [
            ['loc' => route('home'), 'priority' => '1.0'],
            ['loc' => route('services.index'), 'priority' => '0.9'],
            ...array_map(
                fn (string $slug) => ['loc' => route('services.show', $slug), 'priority' => '0.8'],
                ServiceCatalog::slugs(),
            ),
        ];

        return response()
            ->view('seo.sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'Sitemap: '.route('sitemap'),
            '',
        ]);

        return response($content)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
