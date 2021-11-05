<?php


namespace KMLaravel\QueryHelper\Classes;

use Illuminate\Support\Facades\DB;

class QueryHelper
{
    /**
     * @var int
     */
    public $allowedWhereInQueryNumber = 0;

    /**
     * @var string
     */
    public $tableName = '';

    /**
     * @var array
     */
    public $savedItems = [];

    /**
     * @var mixed
     */
    public $ids;
    /**
     * @var mixed
     */
    public $cases;

    /**
     * @var mixed
     */
    public $values;

    /**
     * @var string
     */
    public $fieldToUpdate;
    /**
     * @var string
     */
    public $query;

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
     * @return int
     */
    public function getAllowedWhereInQueryNumber()
    {
        return $this->allowedWhereInQueryNumber;
    }

    /**
     * @param  int  $allowedWhereInQueryNumber
     *
     * @return  mixed
     */
    public function setAllowedWhereInQueryNumber($allowedWhereInQueryNumber)
    {
        $this->allowedWhereInQueryNumber = $allowedWhereInQueryNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getFieldToUpdate()
    {
        return $this->fieldToUpdate;
    }

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
     * @return \App\Helpers\QueryHelper
     */
    public function setSavedItems($savedItems)
    {
        $this->savedItems = $savedItems;
        return $this;
    }

    /**
     * @param  string  $fieldToUpdate
     *
     * @return  QueryHelper
     * @author karam mustafa
     */
    public function setFieldToUpdate($fieldToUpdate)
    {
        $this->fieldToUpdate = $fieldToUpdate;
        return $this;
    }

    /**
     * @return mixed
     * @author karam mustafa
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param  mixed  $values
     *
     * @return  QueryHelper
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
     * @return  QueryHelper
     * @author karam mustafa
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * @param  array  $ids
     *
     * @return  QueryHelper
     * @author karam mustafa
     */
    public function setIds($ids)
    {
        $this->ids = $ids;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getCases()
    {
        return $this->cases;
    }

    /**
     * @param  mixed  $cases
     *
     * @return  QueryHelper
     * @author karam mustafa
     */
    public function setCases($cases)
    {
        $this->cases = $cases;
        return $this;
    }

    public function __construct()
    {
        $this->setAllowedWhereInQueryNumber(config('query_helper.allowed_chunk_number'));
    }

    /**
     * this function return an instance of a current self class, this will be reusable step to add new features.
     *
     * @return mixed
     * @author karam mustsfa
     */
    public static function updateInOneQueryInstance()
    {
        return new self();
    }

    /**
     * @param $method
     * @param $parameters
     *
     * @return mixed
     * @author karam mustsfa
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
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
            foreach ($lists as $list) {
                $items[] = $callbackIfPassed($list);
            }
        }
        $this->savedItems = $items;
        return $items;
    }

    /**
     * this function is execute update multiples rows using case and when statement in sql.
     *
     * @param  string  $key
     *
     * @return QueryHelper
     * @throws \Exception
     * @author karam mustafa
     */
    public function executeUpdateMultiRows($key = null)
    {
        try {
            if (isset($key)) {
                $this->setFieldToUpdate($key);
            }

            $this->buildStatement()->executeAll();

            return $this;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * build query statement
     *
     * @return QueryHelper
     * @throws \Exception
     * @author karam mustafa
     */
    public function buildStatement()
    {
        try {

            $this->setQuery("UPDATE {$this->getTableName()} SET {$this->getFieldToUpdate()} = CASE {$this->getCases()} END WHERE id IN ({$this->getIds()})");

            return $this;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * execute query statement
     *
     * @return QueryHelper
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
     * this function will build [when id = ? then ?] sql query statement.
     *
     * @return QueryHelper
     * @author karam mustafa
     */
    public function bindIdsWithValues()
    {
        $cases = [];
        foreach ($this->getIds() as $index => $id) {
            $val = $this->checkIfInteger($index)
                ? $this->getValues()[$index]
                : '\''.str_replace("'", '"', $this->getValues()[$index]).'\'';

            $cases[] = "WHEN id = {$id} then ".$val;
        }
        $this->setIds(implode(',', $this->getIds()));
        $this->setCases(implode(' ', $cases));

        return $this;
    }

    /**
     * clear all data.
     *
     * @return QueryHelper
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
     * this function will reduce callback functions.
     *
     * @param $tableName
     * @param $ids
     * @param $vales
     * @param $column
     *
     * @return QueryHelper
     * @throws \Exception
     * @author karam mustafa
     */
    public function fastUpdate($tableName, $ids, $vales, $column)
    {
        $this->setTableName($tableName)
            ->setIds($ids)
            ->setValues($vales)
            ->setFieldToUpdate($column)
            ->bindIdsWithValues()
            ->executeUpdateMultiRows();
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
    private function checkIfInteger($index)
    {
        return is_int($this->getValues()[$index])
            || (is_float($this->getValues()[$index])
                && floatval($this->getValues()[$index]));
    }
}
