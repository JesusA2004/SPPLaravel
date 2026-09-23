<?php

/**
 * @param  list<string>  $extensions
 * @return list<string>
 */
function sourceFiles(string $directory, array $extensions): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS));

    foreach ($iterator as $file) {
        if (in_array($file->getExtension(), $extensions, true)) {
            $files[] = $file->getPathname();
        }
    }

    return $files;
}

/**
 * Rutas de archivos públicos (imágenes, video, documentos e íconos)
 * referenciadas desde Vue, Blade, CSS, PHP y el manifest.
 *
 * @return list<string>
 */
function referencedPublicAssets(): array
{
    $files = [
        ...sourceFiles(resource_path('js'), ['vue', 'ts']),
        ...sourceFiles(resource_path('views'), ['php']),
        ...sourceFiles(app_path(), ['php']),
        resource_path('css/app.css'),
        config_path('spp.php'),
        public_path('site.webmanifest'),
    ];

    $pattern = '#/(?:images|video|docs)/[\w./-]+\.(?:webp|jpg|png|mp4|webm|pdf)'
        .'|/(?:favicon[\w.-]*\.(?:ico|png)|apple-touch-icon\.png|icon-[\w-]+\.png|site\.webmanifest)#';

    $assets = [];

    foreach ($files as $file) {
        preg_match_all($pattern, (string) file_get_contents($file), $matches);
        array_push($assets, ...$matches[0]);
    }

    $assets = array_values(array_unique($assets));
    sort($assets);

    return $assets;
}

test('todos los assets referenciados existen en public', function () {
    $assets = referencedPublicAssets();

    expect($assets)->not->toBeEmpty();

    $missing = array_values(array_filter($assets, fn (string $asset) => ! is_file(public_path($asset))));

    expect($missing)->toBe([]);
});

test('las imágenes Open Graph miden 1200x630 y pesan menos de 300 KB', function () {
    foreach (glob(public_path('images/marca/og-*.jpg')) as $image) {
        [$width, $height] = getimagesize($image);

        expect([$width, $height])->toBe([1200, 630])
            ->and(filesize($image))->toBeLessThan(300 * 1024);
    }
});
