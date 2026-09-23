<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use App\Support\ServiceCatalog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $service = ServiceCatalog::find($request->string('servicio')->toString());

        return Inertia::render('Home', [
            'seo' => Seo::make(),
            'philosophy' => config('spp.philosophy'),
            'clientsIntro' => config('spp.clients_intro'),
            'clients' => config('spp.clients'),
            'quotePrefill' => $service['quoteDescription'] ?? null,
        ]);
    }
}
