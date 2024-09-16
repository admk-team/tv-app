<?php

namespace App\Console;

use App\Services\Api;
use App\Models\AppCofig;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $response = Http::timeout(300)->withHeaders(Api::headers())
                ->get(Api::endpoint("/masterfeed"));
            $appconfig = AppCofig::where('app_code', env('APP_CODE'))->first();
            if ($appconfig) {
                $appconfig->update(['api_data' => $response->body()]);
            } else {
                AppCofig::create(['app_code' => env('APP_CODE'), 'api_data' => $response->body()]);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
