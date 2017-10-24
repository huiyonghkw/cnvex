<?php
namespace Bravist\Cnvex\Facade;

use Illuminate\Support\Facades\Facade;

class Cnvex extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'cnvex';
    }
}