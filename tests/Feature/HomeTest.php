<?php

use Inertia\Testing\AssertableInertia as Assert;

test('la página de inicio responde con todas sus secciones', function () {
    $this->get('/')
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Home')
            ->has('philosophy.mission', 2)
            ->has('philosophy.vision', 2)
            ->has('philosophy.values', 7)
            ->has('clients', 8)
            ->has('services', 4)
            ->where('company.contact.phone.label', '777 102 26 76')
            ->where('company.contact.email', 'spp.segpriv@gmail.com')
            ->where('company.contact.whatsapp.number', '527772980092')
        );
});

test('los datos de contacto son consistentes en toda la página', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee('Av. Lomas del Tzompantle 200', false)
        ->assertSee('+52 777 102 26 76', false);
});

test('no existen rutas de autenticación ni rutas heredadas', function (string $uri) {
    $this->get($uri)->assertNotFound();
})->with(['/login', '/register', '/dashboard', '/settings/profile', '/index.php', '/Pages/escolta.php']);

test('una página inexistente responde 404 con el diseño del sitio', function () {
    $this->get('/esto-no-existe')
        ->assertNotFound()
        ->assertSee('noindex', false)
        ->assertInertia(fn (Assert $page) => $page
            ->component('Error')
            ->where('status', 404)
            ->has('services', 4)
            ->has('company.contact')
        );
});
