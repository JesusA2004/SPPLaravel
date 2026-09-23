<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuoteRequest extends FormRequest
{
    /**
     * Campo trampa: los usuarios reales nunca lo ven ni lo llenan.
     */
    public const HONEYPOT_FIELD = 'sitio_web';

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => $this->clean('nombre'),
            'correo' => mb_strtolower($this->clean('correo')),
            'telefono' => $this->normalizePhone($this->clean('telefono')),
            'empresa' => $this->clean('empresa'),
            'descripcion' => $this->clean('descripcion', multiline: true) ?: null,
        ]);
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:120'],
            'correo' => ['required', 'string', 'email:rfc', 'max:150'],
            'telefono' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'empresa' => ['required', 'string', 'min:2', 'max:150'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
            self::HONEYPOT_FIELD => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'telefono.regex' => 'El teléfono debe tener 10 dígitos (por ejemplo, 777 123 45 67).',
            'correo.email' => 'Ingresa un correo electrónico válido.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre completo',
            'correo' => 'correo electrónico',
            'telefono' => 'teléfono',
            'empresa' => 'nombre de la empresa, evento o actividad',
            'descripcion' => 'descripción de servicios',
        ];
    }

    public function isSpam(): bool
    {
        return filled($this->input(self::HONEYPOT_FIELD));
    }

    /**
     * @return array{nombre: string, correo: string, telefono: string, empresa: string, descripcion: string|null}
     */
    public function quoteData(): array
    {
        /** @var array{nombre: string, correo: string, telefono: string, empresa: string, descripcion: string|null} */
        return $this->safe()->only(['nombre', 'correo', 'telefono', 'empresa', 'descripcion']);
    }

    private function clean(string $key, bool $multiline = false): string
    {
        $value = $this->input($key);

        if (! is_string($value)) {
            return '';
        }

        $value = strip_tags($value);
        $value = $multiline
            ? preg_replace("/[^\S\n]+/u", ' ', str_replace(["\r\n", "\r"], "\n", $value))
            : preg_replace('/\s+/u', ' ', $value);

        return trim((string) $value);
    }

    /**
     * Conserva solo los dígitos y elimina la lada internacional de México (+52).
     */
    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if ($digits === '') {
            return $phone;
        }

        if (strlen($digits) === 12 && str_starts_with($digits, '52')) {
            return substr($digits, 2);
        }

        return $digits;
    }
}
