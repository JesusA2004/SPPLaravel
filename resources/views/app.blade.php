@php
    $seo = $page['props']['seo'] ?? null;
@endphp
<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#0a0a0f">
        <meta name="format-detection" content="telephone=no">

        @if ($seo)
            <title data-inertia="">{{ $seo['title'] }}</title>
            <meta data-inertia="description" name="description" content="{{ $seo['description'] }}">
            <meta data-inertia="robots" name="robots" content="{{ $seo['robots'] }}">
            <link data-inertia="canonical" rel="canonical" href="{{ $seo['canonical'] }}">
            <meta data-inertia="og:type" property="og:type" content="{{ $seo['type'] }}">
            <meta data-inertia="og:title" property="og:title" content="{{ $seo['title'] }}">
            <meta data-inertia="og:description" property="og:description" content="{{ $seo['description'] }}">
            <meta data-inertia="og:url" property="og:url" content="{{ $seo['canonical'] }}">
            <meta data-inertia="og:image" property="og:image" content="{{ $seo['image'] }}">
            <meta data-inertia="og:image:width" property="og:image:width" content="{{ $seo['imageWidth'] }}">
            <meta data-inertia="og:image:height" property="og:image:height" content="{{ $seo['imageHeight'] }}">
            <meta data-inertia="og:image:alt" property="og:image:alt" content="{{ $seo['imageAlt'] }}">
            <meta data-inertia="twitter:card" name="twitter:card" content="summary_large_image">
            <meta data-inertia="twitter:title" name="twitter:title" content="{{ $seo['title'] }}">
            <meta data-inertia="twitter:description" name="twitter:description" content="{{ $seo['description'] }}">
            <meta data-inertia="twitter:image" name="twitter:image" content="{{ $seo['image'] }}">
            <script type="application/ld+json">{!! json_encode($seo['schema'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
        @else
            <title>{{ config('spp.name') }}</title>
        @endif
        <meta property="og:site_name" content="{{ config('spp.name') }}">
        <meta property="og:locale" content="es_MX">

        <link rel="icon" href="/favicon.ico" sizes="16x16 24x24 32x32 48x48 64x64">
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
