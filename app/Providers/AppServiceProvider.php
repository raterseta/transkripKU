<?php
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        // Rate Limiter for API call
        RateLimiter::for('api', fn(Request $request) =>
            Limit::perMinute(60)->by($request->user()?->id ?: $request->ip())
        );

        // Rate Limiter for authentication
        RateLimiter::for('auth', fn(Request $request) =>
            Limit::perMinute(5)->by($request->ip())
        );

        // Rate limiter for filament daashboard
        RateLimiter::for('filament', fn(Request $request) =>
            Limit::perMinute(120)->by($request->user()?->id ?: $request->ip())
        );
    }
}
