<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

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
        view()->composer('*',function($view) {
            $response = Http::withHeaders([
                'happcode' => '7376d3829575f06617d9db3f7f6836df'
            ])
            ->get('https://stage.octv.shop/f/v1/masterfeed');

            $view->with('api_data', json_decode($response->getBody()->getContents()));
        });
    }
}
