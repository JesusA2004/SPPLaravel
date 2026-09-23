<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use App\Support\ServiceCatalog;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('services/Index', [
            'seo' => Seo::make(
                title: config('spp.seo.services_title'),
                description: config('spp.seo.services_description'),
                image: '/images/marca/og-servicios.jpg',
                breadcrumbs: [['name' => 'Servicios', 'url' => route('services.index', absolute: false)]],
            ),
        ]);
    }

    public function show(string $slug): Response
    {
        $service = ServiceCatalog::find($slug) ?? abort(404);

        return Inertia::render('services/Show', [
            'seo' => Seo::make(
                title: $service['seoTitle'],
                description: $service['seoDescription'],
                image: $service['ogImage'],
                breadcrumbs: [
                    ['name' => 'Servicios', 'url' => route('services.index', absolute: false)],
                    ['name' => $service['name'], 'url' => $service['url']],
                ],
                service: $service,
            ),
            'service' => $service,
        ]);
    }
}
