<?php

namespace App\Http\Controllers;

use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Home', [
            'seo' => Seo::make(
                title: config('spp.seo.home_title'),
                description: config('spp.seo.home_description'),
            ),
            'philosophy' => config('spp.philosophy'),
            'clientsIntro' => config('spp.clients_intro'),
            'clients' => config('spp.clients'),
        ]);
    }
}
