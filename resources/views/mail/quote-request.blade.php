<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nueva solicitud de cotización</title>
</head>
<body style="margin:0; padding:24px 12px; background-color:#f1f2f6; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:0 auto; background-color:#ffffff; border-radius:8px; overflow:hidden;">
        <tr>
            <td style="background-color:#0b0c14; padding:24px; border-bottom:4px solid #ffcc00;">
                <p style="margin:0; font-size:12px; letter-spacing:2px; text-transform:uppercase; color:#ffcc00;">{{ config('spp.short_name') }}</p>
                <h1 style="margin:6px 0 0; font-size:20px; color:#ffffff;">Nueva solicitud de cotización</h1>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;">
                <p style="margin:0 0 20px; line-height:1.6;">
                    Se recibió una nueva solicitud de información a través del sitio web de
                    <strong>{{ config('spp.name') }}</strong>. Estos son los detalles:
                </p>

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14px; line-height:1.5;">
                    <tr>
                        <td style="padding:8px 0; width:170px; color:#6b7280;">Nombre</td>
                        <td style="padding:8px 0; font-weight:bold;">{{ $quote['nombre'] }}</td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#6b7280;">Correo electrónico</td>
                        <td style="padding:8px 0;"><a href="mailto:{{ $quote['correo'] }}" style="color:#2a2a72;">{{ $quote['correo'] }}</a></td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#6b7280;">Teléfono</td>
                        <td style="padding:8px 0;"><a href="tel:+52{{ $quote['telefono'] }}" style="color:#2a2a72;">{{ $quote['telefono'] }}</a></td>
                    </tr>
                    <tr>
                        <td style="padding:8px 0; color:#6b7280;">Empresa, evento o actividad</td>
                        <td style="padding:8px 0;">{{ $quote['empresa'] }}</td>
                    </tr>
                </table>

                <h2 style="margin:24px 0 8px; font-size:15px; color:#111827;">Descripción de la solicitud</h2>
                <div style="padding:12px 14px; background-color:#f7f7fa; border-left:3px solid #ffcc00; border-radius:4px; font-size:14px; line-height:1.6; white-space:pre-line;">{{ $quote['descripcion'] ?: 'Sin descripción.' }}</div>

                <p style="margin:24px 0 0; line-height:1.6;">Por favor, contacta a esta persona lo antes posible. Puedes responder directamente a este correo.</p>
            </td>
        </tr>
        <tr>
            <td style="padding:16px 24px; background-color:#f7f7fa; font-size:12px; color:#6b7280;">
                {{ config('spp.legal_name') }} · {{ config('app.url') }}
            </td>
        </tr>
    </table>
</body>
</html>
