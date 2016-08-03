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
     * @var Repository
     */
    private $repository;

    /**
     * @param Repository $repo
     */
    public function setRepo(Repository $repo)
    {
        $this->repository = $repo;
    }

    /**
     * @return Repository
     */
    public function getRepo()
    {
        return $this->repository;
    }
}
