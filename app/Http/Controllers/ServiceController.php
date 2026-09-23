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
                'Servicios de seguridad privada',
                'Guardias de seguridad intramuros, escolta, instalación de circuitos cerrados de televisión (CCTV) y cercas eléctricas y de navajas en Cuernavaca, Morelos.',
            ),
        ]);
    }

    public function show(string $slug): Response
    {
        $service = ServiceCatalog::find($slug) ?? abort(404);

        return Inertia::render('services/Show', [
            'seo' => Seo::make($service['name'], $service['intro'], $service['heroImage']['src']),
            'service' => $service,
        ]);
    }
}
