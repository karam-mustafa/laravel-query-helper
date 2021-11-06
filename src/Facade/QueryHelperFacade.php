<?php


namespace KMLaravel\QueryHelper\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \KMLaravel\QueryHelper\Classes\QueryHelper updateInOneQueryInstance()
 * @method static \KMLaravel\QueryHelper\Classes\QueryHelper deleteInstance()
 * @method static \KMLaravel\QueryHelper\Classes\QueryHelper updateInstance()
 * @method static \KMLaravel\QueryHelper\Classes\QueryHelper InsertInstance()
 */
class QueryHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QueryHelperFacade';
    }
}
