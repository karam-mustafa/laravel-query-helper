<?php


namespace KMLaravel\QueryHelper\Classes;


/**
 * Class QueryHelper
 *
 * @author karam mustafa
 * @package KMLaravel\QueryHelper\Classes
 */
class QueryHelper extends BaseHelper
{
    /**
     *
     * @author karam mustafa
     * @var \KMLaravel\QueryHelper\Classes\UpdateHelper
     */
    private $updateHelper;
    /**
     *
     * @author karam mustafa
     * @var \KMLaravel\QueryHelper\Classes\DeleteHelper
     */
    private $deleteHelper;
    /**
     *
     * @author karam mustafa
     * @var \KMLaravel\QueryHelper\Classes\InsertHelper
     */
    private $insertHelper;
    /**
     *
     * @author karam mustafa
     * @var \KMLaravel\QueryHelper\Classes\JoinHelper
     */
    private $joinHelper;

    /**
     * QueryHelper constructor.
     *
     */
    public function __construct()
    {
        $this->initContainer(
            new UpdateHelper,
            new DeleteHelper,
            new InsertHelper,
            new JoinHelper
        );
        $this->setAllowedWhereInQueryNumber(config('query_helper.allowed_chunk_number'));
    }

    /**
     * this function return an instance of update helper class.
     *
     * @return UpdateHelper
     * @author karam mustsfa
     */
    public function updateInstance()
    {
        return $this->updateHelper;
    }

    /**
     * this function return an instance of insert helper class.
     *
     * @return InsertHelper
     * @author karam mustsfa
     */
    public function insertInstance()
    {
        return $this->insertHelper;
    }

    /**
     * this function return an instance of delete helper class.
     *
     * @return DeleteHelper
     * @author karam mustsfa
     */
    public function deleteInstance()
    {
        return $this->deleteHelper;
    }

    /**
     * this function return an instance of join helper class.
     *
     * @return JoinerHelper
     * @author karam mustsfa
     */
    public function joinInstance()
    {
        return $this->joinHelper;
    }

    /**
     * resolve contsrtuct injection if there is any value null.
     *
     * @param  \KMLaravel\QueryHelper\Classes\UpdateHelper  $updateHelper
     * @param  \KMLaravel\QueryHelper\Classes\DeleteHelper  $deleteHelper
     * @param  \KMLaravel\QueryHelper\Classes\InsertHelper  $insertHelper
     * @param  \KMLaravel\QueryHelper\Classes\JoinHelper  $joinHelper
     *
     * @return JoinerHelper
     * @author karam mustsfa
     */
    public function initContainer($updateHelper, $deleteHelper, $insertHelper, $joinHelper)
    {
        $this->updateHelper = $updateHelper;
        $this->deleteHelper = $deleteHelper;
        $this->insertHelper = $insertHelper;
        $this->joinHelper = $joinHelper;
    }

}
