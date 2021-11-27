<?php


namespace KMLaravel\QueryHelper\Classes;


/**
 * Class DeleteHelper
 *
 * @author karam mustafa
 * @package KMLaravel\QueryHelper\Classes
 */
class DeleteHelper extends BaseHelper
{

    /**
     * drop multiple tables by their names in the database
     *
     * @return DeleteHelper
     * @author karam mustafa
     */
    public function dropMultiTables()
    {
        $tables = $this->tables;
        $query = "";
        foreach ($tables as $index => $table) {
            $query .= $index == 0 ? "`$table`" : ",`$table`";
        }
        $this->setQuery(sprintf("DROP TABLE %s;", $query));

        return $this;
    }
}
