<?php


namespace KMLaravel\QueryHelper\Classes;

use \Illuminate\Support\Str;

/**
 * Class JoinHelper
 *
 * @author karam mustafa
 * @package KMLaravel\QueryHelper\Classes
 */
class JoinHelper extends BaseHelper
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
     * @return JoinHelper
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
     * @return JoinHelper
     * @author karam mustafa
     *
     */
    public function buildJoin()
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
     * @param  string  $firstTable
     * @param  string  $secondTable
     *
     * @return string
     * @author karam mustafa
     *
     * @example if we have relation between users and posts
     * this function will return the following 'posts.user_id'
     */
    public function resolveRelation($firstTable, $secondTable)
    {
        return $secondTable.".".Str::singular($firstTable)."_".$this->getField();
    }

    /**
     * fast append the parameters to prepare join queries, instead of write all functions.
     *
     * @param  string  $mainTableName
     * @param  array  $selection
     * @param  array  $tables
     * @param  array  $joinTypes
     *
     * @return mixed
     */
    public function fastJoin($mainTableName, $selection, $tables, $joinTypes)
    {
        return $this->setTableName($mainTableName)
            ->setTables($tables)
            ->setJoinType($joinTypes)
            ->setSelection($selection)
            ->buildJoin()
            ->executeAll();
    }

    /**
     * build the join statement
     *
     * @return void
     * @author karam mustafa
     */
    private function buildStatement()
    {
        foreach ($this->getTables() as $index => $tables) {
            $this->addJoin($tables);
        }
    }

    /**
     * description
     *
     * @param  array  $tables
     *
     * @return void
     * @author karam mustafa
     * @example if we have [users,posts,comments] tables are inside tables property,
     * so this function will build the following query
     * 'JOIN users on users.id = posts.user_id JOIN posts on posts.id = comments.post_id'
     */
    private function addJoin($tables)
    {
        $tables = explode(':', $tables);

        foreach ($tables as $index => $table) {
            if ($index > 0) {
                $this->setQuery(sprintf(
                    "%s %s %s on %s.%s = %s ",
                    $this->getQuery(),
                    $this->getJoinType()[$index] ?? $this->getJoinType()[0],
                    $tables[$index - 1],
                    $tables[$index - 1],
                    $this->getField(),
                    $this->resolveRelation($tables[$index - 1], $table)
                ));
            }
        }
    }
}
