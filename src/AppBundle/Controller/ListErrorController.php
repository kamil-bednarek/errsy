<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Controller;

use AppBundle\Query\MongoDBQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListErrorController extends Controller
{
    private function getDataProvider()
    {
        return $this->get('mongodb_provider')->getCollection('error');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function listAction(Request $request)
    {
        $search = $request->get('search', null);

        $query = new MongoDBQuery('error');

        $query->setQuery([]);
        if ($search !== null) {
            $query->setQuery(['message' => ['$regex' => $request->get('search')]]);
        }

        $query->setSort(['occurred.date' => -1]);

        $paginator = $this->get('knp_paginator');
        $errors = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            25
        );
        
        // replace this example code with whatever you need
        return $this->render(':list:error.html.twig', [
            'errors' => $errors
        ]);
    }
}
