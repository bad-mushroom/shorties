<?php

namespace App\Services\Shorty\Facades;

use Illuminate\Support\Facades\Facade;

class Shorty extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'services.shorty';
    }
}
