<?php


namespace KMLaravel\GeographicalCalculator\Facade;

use Illuminate\Support\Facades\Facade;


class QueryHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QueryHelperFacade';
    }
}
