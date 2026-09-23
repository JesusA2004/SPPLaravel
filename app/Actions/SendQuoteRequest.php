<?php

namespace App\Actions;

use App\Mail\QuoteRequestReceived;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendQuoteRequest
{
    /**
     * Envía la solicitud de cotización al correo de la empresa.
     *
     * @param  array{nombre: string, correo: string, telefono: string, empresa: string, descripcion: string|null}  $data
     */
    public function handle(array $data): bool
    {
        try {
            Mail::to(config('spp.quote.recipient'))->send(new QuoteRequestReceived($data));

            Log::info('Solicitud de cotización enviada.', ['correo' => $data['correo']]);

            return true;
        } catch (Throwable $exception) {
            Log::error('No se pudo enviar la solicitud de cotización.', [
                'correo' => $data['correo'],
                'error' => $exception->getMessage(),
            ]);

            return false;
        }
    }
}
