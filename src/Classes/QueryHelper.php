<?php


namespace KMLaravel\QueryHelper\Classes;


class QueryHelper extends BaseHelper
{
    
    public function __construct()
    {
        $this->setAllowedWhereInQueryNumber(config('query_helper.allowed_chunk_number'));
    }

    /**
     * this function return an instance of update helper class.
     *
     * @return UpdateHelper
     * @author karam mustsfa
     */
    public static function updateInOneQueryInstance()
    {
        return new UpdateHelper();
    }

    /**
     * this function return an instance of update helper class.
     *
     * @return UpdateHelper
     * @author karam mustsfa
     */
    public static function updateInstance()
    {
        return new UpdateHelper();
    }
    /**
     * this function return an instance of insert helper class.
     *
     * @return InsertHelper
     * @author karam mustsfa
     */
    public static function insertInstance()
    {
        return new InsertHelper();
    }

    /**
     * this function return an instance of delete helper class.
     *
     * @return DeleteHelper
     * @author karam mustsfa
     */
    public static function deleteInstance()
    {
        return new DeleteHelper();
    }
    /**
     * this function return an instance of join helper class.
     *
     * @return JoinerHelper
     * @author karam mustsfa
     */
    public static function joinerInstance()
    {
        return new JoinerHelper();
    }
    
}
