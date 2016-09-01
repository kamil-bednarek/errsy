<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Service;

use AppBundle\Query\SearchQuery;
use ONGR\ElasticsearchBundle\Service\Repository;

/**
 * Class SearchService is used to fetch errors from elasticsearch properly
 *
 * @package AppBundle\Service
 *
 * @author  Kamil Bednarek <kb@protonmail.ch>
 */
class SearchService extends SearchQuery
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->setRepository($repository);
    }

    /**
     * Default getter for Repository
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Default setter for Repository
     *
     * @param Repository $repository
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function searchException($searchString)
    {
        $message = $this->getQuerySearchByMessage($searchString);
        $backtrace = $this->getQuerySearchByBacktrace($searchString);

        // Searching in ES
        $search = $this->getRepository()->createSearch();
        $search->addQuery($message);
        $search->addQuery($backtrace);

        $results = $this->getRepository()->execute($search);

        dump($results);
    }
}
