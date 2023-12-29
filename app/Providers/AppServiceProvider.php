<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use App\Services\Api;

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
        view()->composer('*', function ($view) {
            $response = Http::timeout(300)->withHeaders(Api::headers())
                ->get(Api::endpoint('/masterfeed'));

            $view->with('api_data', json_decode($response->getBody()->getContents()));
        });
    }
}
