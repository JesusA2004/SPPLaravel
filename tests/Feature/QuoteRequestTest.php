<?php

use App\Mail\QuoteRequestReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

beforeEach(function () {
    Mail::fake();
    RateLimiter::clear('minuto:127.0.0.1');
    RateLimiter::clear('dia:127.0.0.1');
});

/**
 * @param  array<string, string>  $overrides
 * @return array<string, string>
 */
function validQuote(array $overrides = []): array
{
    return [
        'nombre' => 'María López',
        'correo' => 'maria@example.com',
        'telefono' => '777 123 45 67',
        'empresa' => 'Evento corporativo',
        'descripcion' => 'Requiero guardias para un evento de 200 personas.',
        ...$overrides,
    ];
}

test('una solicitud válida envía el correo a la empresa', function () {
    $this->from('/')
        ->post('/cotizacion', validQuote())
        ->assertRedirect('/')
        ->assertSessionHasNoErrors()
        ->assertInertiaFlash('quote.status', 'success');

    Mail::assertSent(QuoteRequestReceived::class, fn (QuoteRequestReceived $mail) => $mail->hasTo(config('spp.quote.recipient'))
        && $mail->hasReplyTo('maria@example.com')
        && $mail->quote['telefono'] === '7771234567'
        && $mail->quote['nombre'] === 'María López');
});

test('la descripción es opcional', function () {
    $this->post('/cotizacion', validQuote(['descripcion' => '']))
        ->assertSessionHasNoErrors();

    Mail::assertSent(QuoteRequestReceived::class, fn (QuoteRequestReceived $mail) => $mail->quote['descripcion'] === null);
});

test('rechaza una solicitud vacía', function () {
    $this->post('/cotizacion', [])
        ->assertSessionHasErrors(['nombre', 'correo', 'telefono', 'empresa']);

    Mail::assertNothingSent();
});

test('muestra los mensajes de validación en español', function () {
    $this->post('/cotizacion', [])
        ->assertSessionHasErrors(['nombre' => 'El campo nombre completo es obligatorio.']);
});

test('valida el formato del correo electrónico', function (string $email) {
    $this->post('/cotizacion', validQuote(['correo' => $email]))
        ->assertSessionHasErrors(['correo' => 'Ingresa un correo electrónico válido.']);

    Mail::assertNothingSent();
})->with(['sin-arroba', 'correo@', '@dominio.com']);

test('rechaza teléfonos que no tienen 10 dígitos', function (string $phone) {
    $this->post('/cotizacion', validQuote(['telefono' => $phone]))
        ->assertSessionHasErrors(['telefono' => 'El teléfono debe tener 10 dígitos (por ejemplo, 777 123 45 67).']);

    Mail::assertNothingSent();
})->with(['12345', '77712345678', 'abcdefghij', '777-123-45']);

test('acepta teléfonos mexicanos con formato o lada internacional', function (string $phone) {
    $this->post('/cotizacion', validQuote(['telefono' => $phone]))
        ->assertSessionHasNoErrors();

    Mail::assertSent(QuoteRequestReceived::class, fn (QuoteRequestReceived $mail) => $mail->quote['telefono'] === '7771234567');
})->with(['7771234567', '(777) 123-45-67', '+52 777 123 4567']);

test('limita la longitud de los campos', function () {
    $this->post('/cotizacion', validQuote([
        'nombre' => str_repeat('a', 121),
        'descripcion' => str_repeat('a', 2001),
    ]))->assertSessionHasErrors(['nombre', 'descripcion']);

    Mail::assertNothingSent();
});

test('elimina etiquetas HTML de los datos recibidos', function () {
    $this->post('/cotizacion', validQuote(['nombre' => '<b>María</b> López']))
        ->assertSessionHasNoErrors();

    Mail::assertSent(QuoteRequestReceived::class, fn (QuoteRequestReceived $mail) => $mail->quote['nombre'] === 'María López');
});

test('el correo escapa el contenido enviado por el usuario', function () {
    $html = (new QuoteRequestReceived([
        'nombre' => 'María',
        'correo' => 'maria@example.com',
        'telefono' => '7771234567',
        'empresa' => 'Empresa',
        'descripcion' => '"><img src=x onerror=alert(1)>',
    ]))->render();

    expect($html)->not->toContain('<img src=x')
        ->and($html)->toContain('&lt;img src=x onerror=alert(1)&gt;');
});

test('el campo trampa descarta el envío sin avisar al bot', function () {
    $this->post('/cotizacion', validQuote(['sitio_web' => 'https://spam.example']))
        ->assertSessionHasNoErrors()
        ->assertInertiaFlash('quote.status', 'success');

    Mail::assertNothingSent();
});

test('responde con un error controlado si el correo no se puede enviar', function () {
    Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP no disponible'));
    Log::spy();

    $this->from('/')
        ->post('/cotizacion', validQuote())
        ->assertRedirect('/')
        ->assertInertiaFlash('quote.status', 'error');

    Log::shouldHaveReceived('error')->once();
});

test('limita la cantidad de solicitudes por minuto', function () {
    config(['spp.quote.max_per_minute' => 2]);

    $this->post('/cotizacion', validQuote());
    $this->post('/cotizacion', validQuote());

    $this->from('/')
        ->post('/cotizacion', validQuote())
        ->assertRedirect('/')
        ->assertInertiaFlash('quote.status', 'throttled');

    Mail::assertSentCount(2);
});
