<?php


namespace KMLaravel\QueryHelper\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper updateInOneQueryInstance()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper deleteInstance()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper updateInstance()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper InsertInstance()
 */
class QueryHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QueryHelperFacade';
    }
}
