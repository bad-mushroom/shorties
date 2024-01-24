<?php

namespace App\Services\Shorty;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class ShortyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('services.shorty', function ($app) {
            return new Shorty(
                Config::get('shorties.config.short_url_length'),
                Config::get('shorties.config.short_url_prefix')
            );
        });
    }
}
