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
     * @var string
     */
    private $joinType = [];

    /**
     * @return string
     * @author karam mustaf
     */
    public function getJoinType()
    {
        return $this->joinType;
    }

    /**
     * @param  array  $joinType
     *
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
     * @example if we have [users,posts,comments] tables are inside tables property,
     * so this function will build the following query
     * 'JOIN users on users.id = posts.user_id JOIN posts on posts.id = comments.post_id'
     *
     */
    public function innerJoin()
    {
        if (sizeof($this->getJoinType()) == 0) {
            $this->setJoinType(['JOIN']);
        }

        foreach ($this->getTables() as $index => $table) {
            if ($index > 0) {

                $lastTable = $this->getTables()[$index - 1];

                $this->setQuery(sprintf(
                    "%s %s %s on %s.%s = %s ",
                    $this->getQuery(),
                    $this->getJoinType()[$index - 1] ?? $this->getJoinType()[0],
                    $lastTable,
                    $lastTable,
                    $this->getField(),
                    $this->resolveRelation($lastTable, $table)
                ));
            }
        }
        $this->setQuery("SELECT users.id from users ".$this->getQuery());
        
        return $this;
    }

    /**
     * this function is take the second parameter and match the relation field with the first table.
     *
     * @param $lastTale
     * @param $table
     *
     * @return string
     * @author karam mustafa
     *
     * @example if we have relaton between users and posts
     * this function will return the follwoing 'posts.user_id'
     *
     */
    public function resolveRelation($firstTable, $secondTable)
    {
        return $secondTable.".".Str::singular($firstTable)."_".$this->getField();
    }
}
