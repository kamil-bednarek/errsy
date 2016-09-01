<?php
/**
 * Created by PhpStorm.
 * Date: 25.06.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Service;

class MongoDBService
{
    /**
     * @var \MongoDB\Client|null
     */
    private $client = null;

    private $manager = null;

    private $dbName = null;

    /**
     * MongoDBService constructor.
     *
     * @param       $uri
     * @param array $options
     * @param array $driverOptions
     */
    public function __construct($uri, $database, array $options = [], array $driverOptions = [])
    {
        $this->client = new \MongoDB\Client($uri, $options, $driverOptions);
        $this->manager = new \MongoDB\Driver\Manager($uri, $options, $driverOptions);
        $this->dbName = $database;
    }

    /**
     * @return \MongoDB\Client
     */
    public function getClient() : \MongoDB\Client
    {
        return $this->client;
    }

    /**
     * @return \MongoDB\Driver\Manager
     */
    public function getManager() : \MongoDB\Driver\Manager
    {
        return $this->getManager();
    }

    /**
     * Get proper MongoDB Collection
     *
     * @param string $collectionName
     *
     * @return \MongoDB\Collection
     */
    public function getCollection(string $collectionName) : \MongoDB\Collection
    {
        return new \MongoDB\Collection($this->manager, $this->dbName, $collectionName);
    }
}
