<?php

namespace App;

use App\Services\Geolocation\Geolocation;
use App\Services\Geolocation\GeolocationFacade;

class TestPlayground
{
    private $geolocation;

    /** 
    * Note! Geolocation is injected thru DI
    */
    public function __construct(Geolocation $geolocation)
    {
        //$this->geolocation = app(Geolocation::class); // DI using app() explicitly
        $this->geolocation = $geolocation;
        dump($this->geolocation->search('call thru DI'));
        dump(GeolocationFacade::search('call thru Facade'));
    }
}