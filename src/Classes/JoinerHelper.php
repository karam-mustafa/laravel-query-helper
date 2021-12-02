<?php


namespace KMLaravel\QueryHelper\Classes;

use \Illuminate\Support\Str;

/**
 * Class JoinerHelper
 *
 * @author karam mustafa
 * @package KMLaravel\QueryHelper\Classes
 */
class JoinerHelper extends BaseHelper
{

    /**
     *
     * @author karam mustafa
     * @var array
     */
    private $joinType = [];

    /**
     *
     * @author karam mustafa
     * @var string
     */
    protected $selection = ['id'];

    /**
     * @return array
     * @author karam mustaf
     */
    public function getJoinType()
    {
        return $this->joinType;
    }

    /**
     * @param  array  $joinType
     *
     * @return \KMLaravel\QueryHelper\Classes\JoinerHelper
     * @author karam mustaf
     */
    public function setJoinType($joinType)
    {
        $this->joinType = array_merge($this->joinType, $joinType);

        return $this;
    }

    /**
     * get the all inserted tables in tables property,
     * and map these tables, each table will join with the next table in the tables array.
     *
     * @return $this
     * @author karam mustafa
     *
     */
    public function innerJoin()
    {
        $this->buildStatement();

        $this->setQuery(
            sprintf("SELECT %s FROM %s %s",
                $this->getSelection(),
                $this->getTableName(),
                $this->getQuery()
            )
        );
        $this->setIsSelectStatus();
        return $this;
    }

    /**
     * this function is take the second parameter and match the relation field with the first table.
     *
     * @param string $firstTable
     * @param string $secondTable
     *
     * @return string
     * @author karam mustafa
     *
     * @example if we have relaton between users and posts
     * this function will return the follwoing 'posts.user_id'
     */
    public function resolveRelation($firstTable, $secondTable)
    {
        return $secondTable.".".Str::singular($firstTable)."_".$this->getField();
    }

    /**
     * descr
     *
     * @param  string  $mainTableName
     * @param  array  $selection
     * @param  array  $tables
     * @param  array  $joinTypes
     *
     * @return void
     *
     * @example if we have relaton between users and posts
     * this function will return the follwoing 'posts.user_id'
     */
    public function fastJoin($mainTableName, $selection, $tables, $joinTypes)
    {
        return $this->setTableName($mainTableName)
            ->setTables($tables)
            ->setJoinType($joinTypes)
            ->setSelection($selection)
            ->innerJoin()
            ->executeAll();
    }

    /**
     * build the join statemenet
     *
     * @author karam mustafa
     * example if we have [users,posts,comments] tables are inside tables property,
     * so this function will build the following query
     * 'JOIN users on users.id = posts.user_id JOIN posts on posts.id = comments.post_id'
     */
    private function buildStatement()
    {
        foreach ($this->getTables() as $index => $table) {
            if ($index > 0) {

                $lastTable = $this->getTables()[$index - 1];

                $this->setQuery(sprintf(
                    "%s %s %s on %s.%s = %s ",
                    $this->getQuery(),
                    $this->getJoinType()[$index - 1] ?? $this->getJoinType()[0],
                    $table,
                    $lastTable,
                    $this->getField(),
                    $this->resolveRelation($lastTable, $table)
                ));
            }
        }
    }
}
