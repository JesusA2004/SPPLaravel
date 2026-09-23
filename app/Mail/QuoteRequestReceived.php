<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{nombre: string, correo: string, telefono: string, empresa: string, descripcion: string|null}  $quote
     */
    public function __construct(public array $quote) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address($this->quote['correo'], $this->quote['nombre'])],
            subject: 'Nueva solicitud de cotización - '.config('spp.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.quote-request',
            text: 'mail.quote-request-text',
        );
    }
}
