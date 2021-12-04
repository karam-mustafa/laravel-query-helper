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
    private $joinType = 'JOIN';
    /**
     *
     * @author karam mustafa
     * @var string
     */
    private $savedKey = 'joinsResults';

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
     * @param  string  $joinType
     *
     * @return JoinHelper
     * @author karam mustaf
     */
    public function setJoinType($joinType)
    {
        $this->joinType = $joinType;

        return $this;
    }

    /**
     * get the all inserted tables in tables property,
     * and map these tables, each table will join with the next table in the tables array.
     *
     * @return JoinHelper
     * @author karam mustafa
     */
    public function buildJoin()
    {
//        $this->buildStatement();

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
     * @param  array|string  $tables
     * @param  array  $joinTypes
     *
     * @return mixed
     */
    public function fastJoin($mainTableName, $selection, $tables, $joinTypes = ['JOIN'])
    {
        $tables = !is_array($tables) ? [$tables] : $tables;

        $this->loopThrough($tables, function ($index, $table) use ($joinTypes, $selection, $mainTableName) {

            $this->setSavedItems([

                $this->savedKey => $this->setTableName($mainTableName)
                    ->addJoin($table)
                    ->setSelection($selection)
                    ->setJoinType($joinTypes)
                    ->buildJoin()
                    ->executeAll()
            ]);

        });

        return $this->getSavedItems();
    }

    /**
     * build the join statement
     *
     * @return JoinHelper
     * @author karam mustafa
     */
    private function buildStatement()
    {
        foreach ($this->getTables() as $index => $tables) {
            $this->addJoin($tables);
        }

        return $this;
    }

    /**
     * build the join query between tow tables.
     *
     * @param  string  $table
     *
     * @return JoinHelper
     * @author karam mustafa
     * @example if we have [users,posts,comments] tables are inside tables property,
     * so this function will build the following query
     * 'JOIN users on users.id = posts.user_id JOIN posts on posts.id = comments.post_id'
     */
    public function addJoin($table)
    {
        $this->setQuery(sprintf(
            "%s %s %s on %s.%s = %s ",
            $this->getQuery(),
            $this->getJoinType(),
            $table,
            $table,
            $this->getField(),
            $this->resolveRelation($table, $this->getTableName())
        ));

        return $this;
    }
}
