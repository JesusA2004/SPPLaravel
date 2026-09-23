@php
    $seo = $page['props']['seo'] ?? \App\Support\Seo::make();
@endphp
<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#0a0a0f">

        <title data-inertia="">{{ $seo['fullTitle'] }}</title>
        <meta data-inertia="description" name="description" content="{{ $seo['description'] }}">
        <link data-inertia="canonical" rel="canonical" href="{{ $seo['canonical'] }}">
        <meta data-inertia="og:type" property="og:type" content="{{ $seo['type'] }}">
        <meta data-inertia="og:title" property="og:title" content="{{ $seo['fullTitle'] }}">
        <meta data-inertia="og:description" property="og:description" content="{{ $seo['description'] }}">
        <meta data-inertia="og:url" property="og:url" content="{{ $seo['canonical'] }}">
        <meta data-inertia="og:image" property="og:image" content="{{ $seo['image'] }}">
        <meta data-inertia="twitter:card" name="twitter:card" content="summary_large_image">
        <meta property="og:site_name" content="{{ config('spp.name') }}">
        <meta property="og:locale" content="es_MX">
        <script type="application/ld+json">{!! json_encode(\App\Support\Seo::organizationSchema(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon-32x32.png" type="image/png" sizes="32x32">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="manifest" href="/site.webmanifest">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        <x-inertia::head />
    </head>
    <body>
        <x-inertia::app />
    </body>
</html>
