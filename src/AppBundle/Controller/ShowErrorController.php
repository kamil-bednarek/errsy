<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Controller;

use AppBundle\Query\MongoDBQuery;
use MongoDB\BSON\ObjectID;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowErrorController extends Controller
{
    private function getDataProvider()
    {
        return $this->get('mongodb_provider')->getCollection('error');
    }

    /**
     * @Route("/show/{id}", name="show_error")
     * @Method("GET")
     */
    public function listAction($id, Request $request)
    {
        $error = $this->getDataProvider()->findOne(['_id' => new ObjectID($id)]);
        if (null === $error) {
            throw new NotFoundHttpException('Error with identifier not found');
        }

        // Getting the same errors
        $query = new MongoDBQuery('error');
        $query->setQuery([
            'message' => $error->message,
            'app' => $error->app,
            'env' => $error->env,
            '_id' => ['$ne' => new ObjectID($id)]
        ]);
        $query->setSort(['occurred.date' => -1]);

        $paginator = $this->get('knp_paginator');
        $errors = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        // replace this example code with whatever you need
        return $this->render(':show:error.html.twig', [
            'error' => $error,
            'errors' => $errors
        ]);
    }
}
