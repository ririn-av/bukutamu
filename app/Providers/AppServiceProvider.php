<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon; // Tambahkan ini di paling atas

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
        // Set bahasa Carbon ke Indonesia
        Carbon::setLocale('id');
        
        // Set locale aplikasi ke Indonesia
        config(['app.locale' => 'id']);
        
        // Set zona waktu agar sesuai dengan waktu Indonesia (WIB)
        date_default_timezone_set('Asia/Jakarta');
    }
}