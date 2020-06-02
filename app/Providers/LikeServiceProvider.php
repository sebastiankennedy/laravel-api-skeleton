<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LikeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([__DIR__ . '/../../config/like.php' => config_path('like.php')], 'config');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/like.php', 'like');
    }
}
