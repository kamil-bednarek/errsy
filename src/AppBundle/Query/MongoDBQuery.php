<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Query;

class MongoDBQuery
{
    private $collection = null;

    private $query = [];

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * Default getter for Query
     *
     * @return array
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Default setter for Query
     *
     * @param array $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * Default getter for Collection
     *
     * @return null
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Default setter for Collection
     *
     * @param null $collection
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
    }
}
