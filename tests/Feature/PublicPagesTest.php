<?php

use App\Support\ServiceCatalog;
use Inertia\Testing\AssertableInertia as Assert;

test('la página de inicio responde con todas sus secciones', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('<html lang="es-MX">', false)
        ->assertSee('Servicios de Protección Profesional | SPP Seguridad Privada en Morelos')
        ->assertSee('application/ld+json', false)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Home')
            ->has('philosophy.values', 7)
            ->has('clients', 8)
            ->has('services', 4)
            ->where('quotePrefill', null)
            ->where('company.contact.email', 'spp.segpriv@gmail.com')
        );
});

test('la página de inicio precarga la descripción del servicio a cotizar', function () {
    $this->get('/?servicio=escolta')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('quotePrefill', 'Protección personalizada y segura en todo momento')
        );
});

test('un servicio desconocido en la precarga se ignora', function () {
    $this->get('/?servicio=inexistente')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->where('quotePrefill', null));
});

test('el listado de servicios responde', function () {
    $this->get('/servicios')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('services/Index'));
});

test('cada página de servicio responde con su contenido propio', function (string $slug) {
    $service = ServiceCatalog::find($slug);

    $this->get("/servicios/{$slug}")
        ->assertOk()
        ->assertSee($service['name'].' | Servicios de Protección Profesional')
        ->assertInertia(fn (Assert $page) => $page
            ->component('services/Show')
            ->where('service.slug', $slug)
            ->where('service.title', $service['title'])
            ->has('service.gallery.items')
            ->has('service.support.cards', 3)
            ->has('service.highlights', 3)
        );
})->with(ServiceCatalog::slugs());

test('una página inexistente muestra el error 404 en español con el sitio completo', function (string $uri) {
    $this->get($uri)
        ->assertNotFound()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Error')
            ->where('status', 404)
            ->where('seo.title', 'Página no encontrada')
            ->has('services', 4)
            ->has('company.contact')
        );
})->with(['/servicios/no-existe', '/pagina-inexistente']);

test('no existen rutas de autenticación ni rutas heredadas', function (string $uri) {
    $this->get($uri)->assertNotFound();
})->with(['/login', '/register', '/dashboard', '/settings/profile', '/index.php', '/Pages/escolta.php']);

test('el sitemap incluye todas las páginas públicas', function () {
    $response = $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
        ->assertSee('<?xml version="1.0" encoding="UTF-8"?>', false)
        ->assertSee(url('/servicios'), false);

    foreach (ServiceCatalog::slugs() as $slug) {
        $response->assertSee(url("/servicios/{$slug}"), false);
    }
});

test('robots.txt permite el rastreo y apunta al sitemap', function () {
    $this->get('/robots.txt')
        ->assertOk()
        ->assertSee('Allow: /')
        ->assertSee('Sitemap: '.url('/sitemap.xml'));
});
