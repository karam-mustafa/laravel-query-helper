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
     * @var boolean
     */
    private $isSelectStatus = false;

    /**
     * @return bool
     * @author karam mustaf
     */
    public function isSelectStatus()
    {
        return $this->isSelectStatus;
    }

    /**
     * @param  bool  $isSelectStatus
     *
     *
     * @return BaseHelper
     * @author karam mustaf
     */
    public function setIsSelectStatus($isSelectStatus = true)
    {
        $this->isSelectStatus = $isSelectStatus;

        return $this;
    }

    /**
     * @param  array  $selection
     *
     * @return BaseHelper
     * @author karam mustaf
     */
    public function setSelection($selection)
    {
        if ($selection != ['id']) {
            $this->selection = $selection;
        }

        return $this;
    }

    /**
     * @param  boolean  $implode
     *
     * @return string
     * @author karam mustaf
     */
    public function getSelection($implode = true)
    {
        if ($implode) {
            return implode(',', $this->selection);
        }
        return $this->selection;
    }

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
     * @return BaseHelper
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
     * @return BaseHelper
     */
    public function setTables($tables)
    {
        if (is_array($tables)) {
            $this->tables = array_merge($this->tables, $tables);
        }

        if (is_string($tables)) {
            array_push($this->tables, $tables);
        }

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
     * @return BaseHelper
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
     * @return BaseHelper
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
     * @return BaseHelper
     */
    public function setSavedItems($savedItems)
    {
        $this->savedItems = array_merge($this->savedItems, $savedItems);

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
     * @return  BaseHelper
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
                $items[] = $callbackIfPassed($list, $index);
            }
        }
        $this->savedItems = $items;
        return $items;
    }

    /**
     * execute query statement
     *
     * @param  callable|null  $callback
     *
     * @return BaseHelper
     * @throws \Exception
     * @author karam mustafa
     */
    public function executeAll($callback = null)
    {
        try {

            if (isset($callback)) {
                return $callback($this->getQuery());
            }

            if ($this->isSelectStatus()) {
                return DB::select(DB::raw($this->getQuery()));
            }

            DB::statement($this->getQuery());

            return $this;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * clear all inserted data in class properties.
     * this function igore the savedDataItems property,
     * because this package designed to be a strong declarative concept,
     * and we want a node to store all the work on.
     *
     * @return BaseHelper
     * @author karam mustafa
     */
    public function clearAll()
    {
        $this->setIds([]);
        $this->setCases([]);
        $this->setValues([]);
        $this->setQuery('');
        $this->setField('');
        $this->setSelection([]);
        $this->setTables([]);
        $this->setIsSelectStatus(false);

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

    /**
     * loop through specific array and each iteration will execute by a callback.
     *
     * @param  array  $arr
     * @param  callback  $callback
     *
     * @return void
     * @author karam mustafa
     */
    public function loopThrough($arr, $callback)
    {
        foreach ($arr as $key => $value) {
            $callback($key, $value);
        }
    }
}
