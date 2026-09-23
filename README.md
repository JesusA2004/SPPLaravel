# Servicios de Protección Profesional

Sitio web oficial de **Servicios de Protección Profesional S.A. de C.V. (SPP)**, empresa de seguridad privada en Cuernavaca, Morelos, con más de 20 años de experiencia.

El sitio es público (sin inicio de sesión) y presenta la filosofía empresarial, los clientes distinguidos, los servicios de la empresa y un formulario de cotización que envía las solicitudes por correo.

## Stack

| Capa     | Tecnología                                                                      |
| -------- | ------------------------------------------------------------------------------- |
| Backend  | Laravel 13 · PHP 8.3+                                                           |
| Frontend | Vue 3 (Composition API, `<script setup>`, TypeScript) · Inertia.js 3            |
| Estilos  | Tailwind CSS 4 · componentes [shadcn-vue](https://www.shadcn-vue.com) (Reka UI) |
| Iconos   | Lucide (`@lucide/vue`) e iconografía propia de SPP                              |
| Carrusel | Embla Carousel (vía shadcn-vue)                                                 |
| Build    | Vite (vite-plus) · Laravel Wayfinder                                            |
| Pruebas  | Pest · PHPStan (Larastan) · Pint · vue-tsc                                      |

No se usa base de datos: el sitio funciona con sesiones y caché en archivos.

## Requisitos

- PHP 8.3 o superior con las extensiones `mbstring`, `openssl`, `fileinfo` y `curl`
- Composer 2
- Node.js 20 o superior y npm

## Instalación

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
npm run build
```

O en un solo paso: `composer setup`.

### Desarrollo

```bash
composer dev
```

Levanta `php artisan serve` (http://localhost:8000) y el servidor de Vite con recarga en caliente. También puedes ejecutarlos por separado con `php artisan serve` y `npm run dev`.

## Configuración (`.env`)

| Variable                   | Descripción                                                                                                                   |
| -------------------------- | ----------------------------------------------------------------------------------------------------------------------------- |
| `APP_NAME`                 | Nombre de la aplicación (se usa como remitente del correo).                                                                   |
| `APP_URL`                  | URL pública del sitio. Se usa en el sitemap, la URL canónica y Open Graph. **Configúrala con el dominio real en producción.** |
| `APP_LOCALE`               | `es` (mensajes de validación en español).                                                                                     |
| `MAIL_*`                   | Servidor de correo para el formulario de cotización (ver abajo).                                                              |
| `SPP_QUOTE_RECIPIENT`      | Correo que recibe las solicitudes de cotización. Por defecto `spp.segpriv@gmail.com`.                                         |
| `SPP_QUOTE_MAX_PER_MINUTE` | Envíos permitidos por minuto y por IP (por defecto 3).                                                                        |
| `SPP_QUOTE_MAX_PER_DAY`    | Envíos permitidos por día y por IP (por defecto 20).                                                                          |
| `INERTIA_SSR_ENABLED`      | Renderizado en servidor opcional; no es necesario (los metadatos SEO ya se generan en Blade).                                 |

### Correo

En local, `MAIL_MAILER=log` escribe los correos en `storage/logs/laravel.log`, así puedes probar el formulario sin enviar nada.

Para producción con Gmail:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=spp.segpriv@gmail.com
MAIL_PASSWORD="contraseña-de-aplicación-de-google"
MAIL_FROM_ADDRESS="spp.segpriv@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
SPP_QUOTE_RECIPIENT=spp.segpriv@gmail.com
```

`MAIL_PASSWORD` debe ser una **contraseña de aplicación** de Google (requiere verificación en dos pasos en la cuenta). Nunca la guardes en el código ni en el repositorio.

## Formulario de cotización

1. El usuario llena nombre, correo, teléfono (10 dígitos), empresa/evento/actividad y una descripción opcional. Desde cada página de servicio la descripción llega precargada.
2. Vue valida los campos antes de enviar y muestra los errores debajo de cada campo; el botón muestra estado de carga y se bloquea para evitar doble envío.
3. `POST /cotizacion` → `QuoteRequestController`, validado por `App\Http\Requests\QuoteRequest` (limpia etiquetas HTML, normaliza el teléfono y aplica las reglas).
4. `App\Actions\SendQuoteRequest` envía el Mailable `QuoteRequestReceived` (HTML + texto plano, contenido escapado, `Reply-To` con el correo del solicitante). Si falla, registra el error en el log y el usuario ve un mensaje amable, nunca la excepción.
5. La respuesta regresa como _flash_ de Inertia y el sitio muestra un diálogo de éxito (con los datos enviados) o de error.

Protección contra spam: token CSRF, límite de envíos por IP (`throttle:cotizaciones`) y un campo trampa (_honeypot_) invisible.

## Comandos útiles

```bash
npm run build          # Compila los assets para producción
npm run check          # Lint y formato (vite-plus)
npm run types:check    # Verificación de tipos de Vue/TypeScript
php artisan test       # Pruebas (Pest)
composer lint          # Formatea el PHP con Pint
composer types:check   # Análisis estático con PHPStan
composer ci:check      # Todo lo anterior
php artisan route:list # Rutas del sitio
```

## Rutas

| Método | URL                                | Descripción                                                         |
| ------ | ---------------------------------- | ------------------------------------------------------------------- |
| GET    | `/`                                | Inicio: hero con video, filosofía, clientes, servicios y cotización |
| GET    | `/servicios`                       | Todos los servicios                                                 |
| GET    | `/servicios/guardias-de-seguridad` | Guardias de seguridad intramuros                                    |
| GET    | `/servicios/escolta`               | Escolta                                                             |
| GET    | `/servicios/cctv`                  | Instalación de circuitos cerrados de televisión                     |
| GET    | `/servicios/cercas-electricas`     | Instalación de cercas eléctricas y navajas                          |
| POST   | `/cotizacion`                      | Envío del formulario de cotización                                  |
| GET    | `/sitemap.xml`                     | Sitemap para buscadores                                             |
| GET    | `/robots.txt`                      | Reglas para rastreadores (apunta al sitemap)                        |

`/?servicio={slug}#cotizar` abre el formulario del inicio con la descripción del servicio precargada.

## Producción

```bash
composer install --no-dev --optimize-autoloader
npm ci && npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

- Apunta el servidor web a la carpeta `public/`.
- Usa `APP_ENV=production`, `APP_DEBUG=false` y el dominio real en `APP_URL`.
- Con HTTPS, agrega `SESSION_SECURE_COOKIE=true`.
- Da permisos de escritura a `storage/` y `bootstrap/cache/`.
- Registra el sitemap (`https://tu-dominio/sitemap.xml`) en Google Search Console.

## SEO

- Título, descripción, URL canónica y Open Graph por página, generados en el servidor (`App\Support\Seo`) y actualizados por Inertia al navegar.
- Datos estructurados `LocalBusiness` (schema.org) con dirección, teléfono, redes y servicios.
- `sitemap.xml` y `robots.txt` dinámicos, URLs amigables, `lang="es-MX"`, encabezados jerárquicos y textos alternativos.

## Estructura principal

```
app/
├── Actions/SendQuoteRequest.php        Envío del correo de cotización
├── Http/Controllers/                   Home, servicios, cotización y SEO
├── Http/Requests/QuoteRequest.php      Validación y limpieza del formulario
├── Mail/QuoteRequestReceived.php       Mailable de la solicitud
└── Support/
    ├── ServiceCatalog.php              Contenido de los servicios
    └── Seo.php                         Metadatos y datos estructurados
config/spp.php                          Datos de la empresa, filosofía, clientes y formulario
lang/es/validation.php                  Mensajes de validación en español
resources/
├── assets/originales/                  Archivos originales del sitio anterior (no se publican)
├── css/app.css                         Tema de marca (Tailwind)
├── views/app.blade.php                 Plantilla raíz con SEO
├── views/mail/                         Plantillas del correo
└── js/
    ├── pages/                          Home, services/Index, services/Show, Error
    ├── layouts/SiteLayout.vue          Header, contenido, footer y WhatsApp
    ├── components/
    │   ├── layout/                     SiteHeader, SiteFooter, WhatsAppButton, BrandLogo
    │   ├── navigation/                 DesktopNav, MobileNav, useNavigation
    │   ├── home/                       Hero, Filosofía, Clientes
    │   ├── services/                   Tarjetas, intro, galería, supervisión, CTA
    │   ├── contact/                    Sección, formulario y diálogo de cotización
    │   ├── common/                     SiteLink, SectionHeading, PageHeader, SeoHead, BrandIcon
    │   └── ui/                         Componentes shadcn-vue
    ├── lib/                            Navegación, scroll, iconos, animación v-reveal
    └── types/                          Tipos de TypeScript
public/
├── images/                             Imágenes optimizadas (WebP): marca, iconos, clientes, home, servicios
├── video/spp-inicio.mp4                Video del hero (optimizado)
└── docs/                               Aviso de Registro y Licencia de Funcionamiento (PDF)
tests/Feature/                          Pruebas de páginas y del formulario
```

### Editar contenido

- **Datos de contacto, filosofía, clientes:** `config/spp.php`.
- **Servicios (textos, imágenes, galerías):** `app/Support/ServiceCatalog.php`.
- **Menú:** `resources/js/lib/navigation.ts`.

Tras cambiar la configuración en producción ejecuta `php artisan config:cache`.
