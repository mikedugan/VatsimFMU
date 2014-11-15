<?php namespace Vatsim\Fmu\Facades;

use Illuminate\Support\Facades\Facade;

class FMU extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'vatsimfmu'; }

}