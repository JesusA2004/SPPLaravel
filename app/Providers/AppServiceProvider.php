<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureRateLimiting();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );
    }

    /**
     * Limita los envíos del formulario de cotización por dirección IP.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('cotizaciones', function (Request $request) {
            $throttled = function () {
                Inertia::flash('quote', ['status' => 'throttled']);

                return back();
            };

            return [
                Limit::perMinute(config('spp.quote.max_per_minute'))->by('minuto:'.$request->ip())->response($throttled),
                Limit::perDay(config('spp.quote.max_per_day'))->by('dia:'.$request->ip())->response($throttled),
            ];
        });
    }
}
