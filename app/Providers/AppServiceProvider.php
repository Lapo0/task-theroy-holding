<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ...
    }

    public function boot()
    {
        // Includi l'helper
        if (file_exists(app_path('Helpers/helpers.php'))) {
            require_once app_path('Helpers/helpers.php');
        }
    }
}
