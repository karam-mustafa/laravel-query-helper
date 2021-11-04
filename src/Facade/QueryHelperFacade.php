<?php


namespace KMLaravel\GeographicalCalculator\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \KMLaravel\QueryHelper\Classes\QueryHelper initCoordinates($lat1, $lat2, $lon1, $lon2, $options)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getDistance()
 */
class QueryHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QueryHelperFacade';
    }
}
