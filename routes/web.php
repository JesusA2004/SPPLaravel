<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteRequestController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\ServiceController;
use App\Support\ServiceCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('servicios', [ServiceController::class, 'index'])->name('services.index');

Route::get('servicios/{slug}', [ServiceController::class, 'show'])
    ->whereIn('slug', ServiceCatalog::slugs())
    ->name('services.show');

Route::post('cotizacion', [QuoteRequestController::class, 'store'])
    ->middleware('throttle:cotizaciones')
    ->name('quote.store');

Route::get('sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('robots.txt', [SeoController::class, 'robots'])->name('robots');
