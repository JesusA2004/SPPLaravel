<?php

use App\Support\ServiceCatalog;
use Inertia\Testing\AssertableInertia as Assert;

test('el listado de servicios responde', function () {
    $this->get('/servicios')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('services/Index')
            ->has('services', 4)
        );
});

test('cada página de servicio responde con su contenido propio', function (string $slug) {
    $service = ServiceCatalog::find($slug);

    $this->get("/servicios/{$slug}")
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('services/Show')
            ->where('service.slug', $slug)
            ->where('service.title', $service['title'])
            ->where('service.quoteDescription', $service['quoteDescription'])
            ->has('service.overview')
            ->has('service.audience')
            ->has('service.gallery.items')
            ->has('service.support.cards', 3)
            ->has('service.highlights', 3)
        );
})->with(ServiceCatalog::slugs());

test('un servicio inexistente responde 404', function () {
    $this->get('/servicios/no-existe')
        ->assertNotFound()
        ->assertInertia(fn (Assert $page) => $page->component('Error')->where('status', 404));
});

test('cada servicio tiene título y descripción SEO únicos', function () {
    $services = array_map(ServiceCatalog::find(...), ServiceCatalog::slugs());

    $titles = array_column($services, 'seoTitle');
    $descriptions = array_column($services, 'seoDescription');

    expect(array_unique($titles))->toHaveCount(count($services))
        ->and(array_unique($descriptions))->toHaveCount(count($services));

    foreach ($services as $service) {
        expect(mb_strlen($service['seoTitle']))->toBeLessThanOrEqual(70)
            ->and(mb_strlen($service['seoDescription']))->toBeLessThanOrEqual(165);
    }
});
