<?php


namespace KMLaravel\QueryHelper\Classes;


use Illuminate\Support\Facades\DB;

abstract class BaseHelper
{
    /**
     * @var string
     */
    public $tableName = '';
    /**
     * @var array
     */
    public $tables = [];
    /**
     * @var mixed
     */
    public $ids;
    /**
     * @var mixed
     */
    public $values;
    /**
     * @var string
     */
    public $query;
    /**
     * @var string
     */
    public $field = 'id';
    
    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
    
    /**
     * @param  string  $field
     *
     * @return \KMLaravel\QueryHelper\Classes\UpdateHelper
     * @author karam mustafa
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param $tables
     *
     * @return \KMLaravel\QueryHelper\Classes\BaseHelper
     */
    public function setTables($tables)
    {
        $this->tables = $tables;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param  string  $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return array
     * @author karam mustafa
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param  mixed  $values
     *
     * @return BaseHelper
     * @author karam mustafa
     */
    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param  string  $tableName
     *
     * @return \KMLaravel\QueryHelper\Classes\BaseHelper
     * @author karam mustafa
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * @return array
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @param  array  $ids
     *
     * @return \KMLaravel\QueryHelper\Classes\BaseHelper
     * @author karam mustafa
     */
    public function setIds($ids)
    {
        $this->ids = $ids;
        return $this;

    }

    /**
     * @var int
     */
    public $allowedWhereInQueryNumber = 0;
    /**
     * @var array
     */
    public $savedItems = [];

    /**
     * @return array
     */
    public function getSavedItems()
    {
        return $this->savedItems;
    }

    /**
     * @param  array  $savedItems
     *
     * @return \KMLaravel\QueryHelper\Classes\BaseHelper
     */
    public function setSavedItems($savedItems)
    {
        $this->savedItems = $savedItems;
        return $this;
    }

    /**
     * @return int
     */
    public function getAllowedWhereInQueryNumber()
    {
        return $this->allowedWhereInQueryNumber;
    }

    /**
     * @param  int  $allowedWhereInQueryNumber
     *
     * @return  \KMLaravel\QueryHelper\Classes\BaseHelper
     */
    public function setAllowedWhereInQueryNumber($allowedWhereInQueryNumber)
    {
        $this->allowedWhereInQueryNumber = $allowedWhereInQueryNumber;
        return $this;
    }

    /**
     * this function will chunk set of data to custom size, and each size will apply the callback.
     *
     * @param $ids
     * @param  callable|null  $callbackIfPassed
     * @param  null  $chunkCountAllowed
     *
     * @return mixed
     */
    public function checkIfQueryAllowed($ids, $callbackIfPassed = null, $chunkCountAllowed = null)
    {
        if (!isset($chunckCountAllowed)) {
            $chunkCountAllowed = $this->getAllowedWhereInQueryNumber();
        }

        $items = [];
        $lists = collect($ids)->chunk($chunkCountAllowed + 1);
        if (!is_null($callbackIfPassed)) {
            foreach ($lists as $index => $list) {
                $items[] = $callbackIfPassed($list , $index);
            }
        }
        $this->savedItems = $items;
        return $items;
    }

    /**
     * execute query statement
     *
     * @return \KMLaravel\QueryHelper\Classes\BaseHelper
     * @throws \Exception
     * @author karam mustafa
     */
    public function executeAll()
    {
        try {

            DB::statement($this->getQuery());

            return $this;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * clear all data.
     *
     * @return \KMLaravel\QueryHelper\Classes\BaseHelper
     * @author karam mustafa
     */
    public function clearAll()
    {
        $this->setIds([]);
        $this->setCases([]);
        $this->setValues([]);
        $this->setQuery('');

        return $this;
    }

    /**
     * check if the value is float.
     *
     * @param $index
     *
     * @return bool
     * @author karam mustafa
     */
    public function checkIfInteger($index)
    {
        return is_int($this->getValues()[$index])
            || (is_float($this->getValues()[$index])
                && floatval($this->getValues()[$index]));
    }
}
