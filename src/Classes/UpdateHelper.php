<?php


namespace KMLaravel\QueryHelper\Classes;


class UpdateHelper extends BaseHelper
{
    
    /**
     * @var mixed
     */
    public $cases;

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
     * @return \KMLaravel\QueryHelper\Classes\UpdateHelper
     * @author karam mustafa
     */
    public function setCases($cases)
    {
        $this->cases = $cases;
        return $this;
    }

    /**
     * this function is execute update multiples rows using case and when statement in sql.
     *
     * @param  string  $key
     *
     * @return \KMLaravel\QueryHelper\Classes\UpdateHelper
     * @throws \Exception
     * @author karam mustafa
     */
    public function executeUpdateMultiRows($key = null)
    {
        try {
            if (isset($key)) {
                $this->setField($key);
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
     * @return \KMLaravel\QueryHelper\Classes\UpdateHelper
     * @throws \Exception
     * @author karam mustafa
     */
    public function buildStatement()
    {
        try {
            $query = sprintf(
                "UPDATE %s SET %s =  CASE %s END WHERE id IN (%s)",
                $this->getTableName(),
                $this->getField(),
                $this->getCases(),
                $this->getIds()
            );

            $this->setQuery($query);

            return $this;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * this function will build [when id = ? then ?] sql query statement.
     *
     * @return \KMLaravel\QueryHelper\Classes\UpdateHelper
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
     * this function will reduce callback functions.
     *
     * @param $tableName
     * @param $ids
     * @param $vales
     * @param $column
     *
     * @return \KMLaravel\QueryHelper\Classes\UpdateHelper
     * @author karam mustafa
     */
    public function fastUpdate($tableName, $ids, $vales, $column)
    {
        $this->setTableName($tableName)
            ->setIds($ids)
            ->setValues($vales)
            ->setField($column)
            ->bindIdsWithValues()
            ->executeUpdateMultiRows();
        return $this;
    }
}
