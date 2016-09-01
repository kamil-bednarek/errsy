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
        $query = new MongoDBQuery('error');
        $query->setQuery([]);
        $query->setSort(['occurred.date' => -1]);

        $paginator = $this->get('knp_paginator');
        $errors = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            25
        );
//
//        $results = $this->get('ongr_filter_manager.search_list')->handleRequest($request);
//
//
//        $this->get('erkam.search.service')->searchException('for array with keys');
        
        // replace this example code with whatever you need
        return $this->render(':list:error.html.twig', [
            'errors' => $errors
        ]);
    }
}
