<?php

namespace App\Http\Middleware;

use App\Support\ServiceCatalog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'company' => Inertia::once(fn () => $this->company()),
            'services' => Inertia::once(fn () => ServiceCatalog::summaries()),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function company(): array
    {
        $whatsapp = config('spp.contact.whatsapp');

        return [
            'name' => config('spp.name'),
            'shortName' => config('spp.short_name'),
            'legalName' => config('spp.legal_name'),
            'yearsOfExperience' => config('spp.years_of_experience'),
            'description' => config('spp.description'),
            'about' => config('spp.about'),
            'qualityPolicy' => config('spp.quality_policy'),
            'contact' => [
                'address' => config('spp.contact.address'),
                'city' => config('spp.contact.city'),
                'phone' => config('spp.contact.phone'),
                'email' => config('spp.contact.email'),
                'whatsapp' => [
                    'label' => $whatsapp['label'],
                    'url' => 'https://wa.me/'.$whatsapp['number'].'?text='.rawurlencode($whatsapp['message']),
                ],
                'mapsUrl' => config('spp.contact.maps_url'),
                'mapsEmbedUrl' => config('spp.contact.maps_embed_url'),
            ],
            'social' => config('spp.social'),
            'documents' => config('spp.documents'),
        ];
    }
}
