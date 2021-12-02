<?php


namespace KMLaravel\QueryHelper\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \KMLaravel\QueryHelper\Classes\UpdateHelper updateInOneQueryInstance()
 * @method static \KMLaravel\QueryHelper\Classes\DeleteHelper deleteInstance()
 * @method static \KMLaravel\QueryHelper\Classes\UpdateHelper updateInstance()
 * @method static \KMLaravel\QueryHelper\Classes\InsertHelper insertInstance()
 * @method static \KMLaravel\QueryHelper\Classes\JoinerHelper joinerInstance()
 */
class QueryHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QueryHelperFacade';
    }
}
