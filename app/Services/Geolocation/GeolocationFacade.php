<?php

namespace App\Services\Geolocation;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array search(string $string)
 * @see Geolocation
 */
class GeolocationFacade extends Facade
{
    // Note! This should be overridden to make Facade works
    protected static function getFacadeAccessor()
    {
        return Geolocation::class;
    }
}