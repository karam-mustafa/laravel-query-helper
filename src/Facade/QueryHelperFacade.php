<?php


namespace KMLaravel\QueryHelper\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getQuery()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper setQuery($query)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getAllowedWhereInQueryNumber()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper setAllowedWhereInQueryNumber($allowedWhereInQueryNumber)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getFieldToUpdate()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper setFieldToUpdate($fieldToUpdate)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getValues()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper setValues()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getTableName()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper setTableName($tableName)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getIds()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper setIds($ids)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper getCases()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper setCases($cases)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper checkIfQueryAllowed($ids, $callbackIfPassed = null, $chunkCountAllowed = null)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper executeUpdateMultiRows($key = null)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper buildStatement()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper executeAll()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper bindIdsWithValues()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper clearAll()
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper fastUpdate($tableName, $ids, $vales, $column)
 * @method \KMLaravel\QueryHelper\Classes\QueryHelper checkIfInteger($index)
 */
class QueryHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'QueryHelperFacade';
    }
}
