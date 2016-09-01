<?php
/**
 * Created by PhpStorm.
 * Date: 03.08.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Service;

use ONGR\ElasticsearchBundle\Service\Repository;

/**
 * Trait ErkamServiceTrait
 *
 * @package AppBundle\Service
 *
 * @author  Kamil Bednarek <kb@protonmail.ch>
 */
trait ErkamServiceTrait
{
    /**
     * @var MongoDBService
     */
    private $provider;

    /**
     * @param MongoDBService $provider
     */
    public function setProvider(MongoDBService $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return MongoDBService
     */
    public function getProvider()
    {
        return $this->provider;
    }
}
