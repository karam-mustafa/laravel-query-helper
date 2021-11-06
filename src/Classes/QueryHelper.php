<?php


namespace KMLaravel\QueryHelper\Classes;

use Illuminate\Support\Facades\DB;
use KMLaravel\UpdateHelper\Classes\UpdateHelper;

class QueryHelper
{
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
     * @return \KMLaravel\QueryHelper\Classes\QueryHelper
     */
    public function setSavedItems($savedItems)
    {
        $this->savedItems = $savedItems;
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
     * @return  mixed
     */
    public function setAllowedWhereInQueryNumber($allowedWhereInQueryNumber)
    {
        $this->allowedWhereInQueryNumber = $allowedWhereInQueryNumber;
        return $this;
    }

    public function __construct()
    {
        $this->setAllowedWhereInQueryNumber(config('query_helper.allowed_chunk_number'));
    }

    /**
     * this function return an instance of an update helper class.
     *
     * @return mixed
     * @author karam mustsfa
     */
    public static function updateInOneQueryInstance()
    {
        return new UpdateHelper();
    }

    /**
     * this function return an instance of an update helper class.
     *
     * @return mixed
     * @author karam mustsfa
     */
    public static function updateInstance()
    {
        return new UpdateHelper();
    }
    /**
     * this function return an instance of an insert helper class.
     *
     * @return mixed
     * @author karam mustsfa
     */
    public static function InsertInstance()
    {
        return new InsertHelper();
    }

    /**
     * this function return an instance of a delete helper class.
     *
     * @return mixed
     * @author karam mustsfa
     */
    public static function deleteInstance()
    {
        return new DeleteHelper();
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

}
