<?php


namespace KMLaravel\QueryHelper\Classes;


class QueryHelper extends BaseHelper
{
    
    public function __construct()
    {
        $this->setAllowedWhereInQueryNumber(config('query_helper.allowed_chunk_number'));
    }

    /**
     * this function return an instance of an update helper class.
     *
     * @return UpdateHelper
     * @author karam mustsfa
     */
    public static function updateInOneQueryInstance()
    {
        return new UpdateHelper();
    }

    /**
     * this function return an instance of an update helper class.
     *
     * @return UpdateHelper
     * @author karam mustsfa
     */
    public static function updateInstance()
    {
        return new UpdateHelper();
    }
    /**
     * this function return an instance of an insert helper class.
     *
     * @return InsertHelper
     * @author karam mustsfa
     */
    public static function InsertInstance()
    {
        return new InsertHelper();
    }

    /**
     * this function return an instance of a delete helper class.
     *
     * @return DeleteHelper
     * @author karam mustsfa
     */
    public static function deleteInstance()
    {
        return new DeleteHelper();
    }
    
}
