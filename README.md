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
| Carrusel | Embla Carousel (vía shadcn-vue) con desplazamiento continuo                     |
| Build    | Vite 8 · Laravel Wayfinder · Prettier                                           |
| Pruebas  | Pest · PHPStan (Larastan) · Pint · vue-tsc                                      |

No se usa base de datos: el sitio funciona con sesiones y caché en archivos.

## Requisitos

- PHP 8.3 o superior con las extensiones `mbstring`, `openssl`, `fileinfo` y `curl`
- Composer 2
- Node.js 20.19 o superior (22 LTS recomendado) y npm

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

| Variable                   | Descripción                                                                                                                             |
| -------------------------- | --------------------------------------------------------------------------------------------------------------------------------------- |
| `APP_NAME`                 | Nombre de la aplicación (se usa como remitente del correo).                                                                             |
| `APP_URL`                  | URL canónica del sitio: `https://seguridadprivadaspp.com` en producción (sin `www`). Se usa en canonical, Open Graph, sitemap y robots. |
| `APP_LOCALE`               | `es` (mensajes de validación en español).                                                                                               |
| `MAIL_*`                   | Servidor de correo para el formulario de cotización (ver abajo).                                                                        |
| `SPP_QUOTE_RECIPIENT`      | Correo que recibe las solicitudes de cotización. Por defecto `spp.segpriv@gmail.com`.                                                   |
| `SPP_QUOTE_MAX_PER_MINUTE` | Envíos permitidos por minuto y por IP (por defecto 3).                                                                                  |
| `SPP_QUOTE_MAX_PER_DAY`    | Envíos permitidos por día y por IP (por defecto 20).                                                                                    |
| `INERTIA_SSR_ENABLED`      | Renderizado en servidor opcional; no es necesario (los metadatos SEO ya se generan en Blade).                                           |

### Correo

En local, `MAIL_MAILER=log` escribe los correos en `storage/logs/laravel.log`, así puedes probar el formulario sin enviar nada.

Para producción con Gmail:

```dotenv
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=spp.segpriv@gmail.com
MAIL_PASSWORD="contraseña-de-aplicación-de-google"
MAIL_FROM_ADDRESS="spp.segpriv@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
SPP_QUOTE_RECIPIENT=spp.segpriv@gmail.com
```

`MAIL_PASSWORD` debe ser una **contraseña de aplicación** de Google (requiere verificación en dos pasos en la cuenta). Nunca la guardes en el código ni en el repositorio. Con el puerto 587 Laravel negocia STARTTLS automáticamente (`MAIL_SCHEME=null`); para SSL directo usa `MAIL_PORT=465`. Laravel 13 ya no utiliza `MAIL_ENCRYPTION`.

## Formulario de cotización

1. En la página de inicio el formulario está completo en la sección **Cotizar**. En las páginas de servicio, el botón «Solicitar cotización» abre el mismo formulario en un diálogo, con la descripción del servicio precargada.
2. Vue valida los campos antes de enviar y muestra los errores debajo de cada campo; el botón muestra estado de carga y se bloquea para evitar doble envío.
3. `POST /cotizacion` → `QuoteRequestController`, validado por `App\Http\Requests\QuoteRequest` (limpia etiquetas HTML, normaliza el teléfono y aplica las reglas).
4. `App\Actions\SendQuoteRequest` envía el Mailable `QuoteRequestReceived` (HTML + texto plano, contenido escapado, `Reply-To` con el correo del solicitante). Si falla, registra el error en el log y el usuario ve un mensaje amable, nunca la excepción.
5. La respuesta regresa como _flash_ de Inertia: el éxito se confirma en un diálogo con los datos enviados; los errores (servidor, límite de envíos o sesión expirada) se muestran dentro del formulario, que conserva lo capturado.

Protección contra spam: token CSRF, límite de envíos por IP (`throttle:cotizaciones`) y un campo trampa (_honeypot_) invisible.

## Comandos útiles

```bash
npm run build          # Compila los assets para producción
npm run types:check    # Verificación de tipos de Vue/TypeScript
npm run format         # Formatea resources/ con Prettier
npm run check          # Tipos + verificación de formato
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
- Registra el sitemap (`https://seguridadprivadaspp.com/sitemap.xml`) en Google Search Console.

### Nginx (Linux)

El dominio canónico es `https://seguridadprivadaspp.com`. Redirige `www` y HTTP de forma permanente:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name seguridadprivadaspp.com www.seguridadprivadaspp.com;
    return 301 https://seguridadprivadaspp.com$request_uri;
}

server {
    listen 443 ssl http2;
    server_name www.seguridadprivadaspp.com;
    # ssl_certificate ...
    return 301 https://seguridadprivadaspp.com$request_uri;
}

server {
    listen 443 ssl http2;
    server_name seguridadprivadaspp.com;
    root /var/www/SPP/public;
    index index.php;
    # ssl_certificate ...

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Assets con hash de Vite, imágenes, video y fuentes: caché larga.
    location ~* ^/(build|images|video)/ {
        expires 30d;
        add_header Cache-Control "public";
        access_log off;
        try_files $uri =404;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

`robots.txt` y `sitemap.xml` los genera Laravel: no existe un `public/robots.txt` estático. En producción todas las URL se generan con `APP_URL` (`URL::forceRootUrl`), así que el canonical nunca apunta a una IP, a `localhost` ni a `www`.

## SEO

- Título, descripción, URL canónica y Open Graph por página, generados en el servidor (`App\Support\Seo`) y actualizados por Inertia al navegar.
- Datos estructurados (schema.org, `@graph`): `ProfessionalService` (empresa con NAP, geo y redes), `WebSite`, `WebPage`, `BreadcrumbList` en páginas internas y `Service` en cada servicio con `provider` → la empresa. No se publican reseñas ni precios.
- Imágenes para compartir (1200×630, < 300 KB) por página en `public/images/marca/og-*.jpg`.
- `sitemap.xml` con `<lastmod>` tomado de `spp.seo.updated_at` en `config/spp.php` (actualízalo al cambiar contenido) y `robots.txt` dinámico.
- Un único `h1` por página, URLs amigables, `lang="es-MX"` y textos alternativos.

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
├── video/                              Video del hero: WebM (VP9) y MP4 (H.264), 1080p y 720p
└── docs/                               Aviso de Registro y Licencia de Funcionamiento (PDF)
tests/Feature/                          Home, servicios, SEO, formulario y assets
```

### Editar contenido

- **Datos de contacto, filosofía, clientes:** `config/spp.php`.
- **Servicios (textos, SEO, imágenes, galerías):** `app/Support/ServiceCatalog.php`.
- **Títulos y descripciones SEO de inicio y servicios:** `config/spp.php` (`seo`).
- **Menú:** `resources/js/lib/navigation.ts`.

Tras cambiar la configuración en producción ejecuta `php artisan config:cache`.
