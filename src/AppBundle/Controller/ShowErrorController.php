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

class ShowErrorController extends Controller
{
    private function getDataProvider()
    {
        return $this->get('mongodb_provider')->getCollection('error');
    }

    /**
     * @Route("/show/{id}", name="show_error")
     */
    public function listAction($id, Request $request)
    {
        $error = $this->getDataProvider()->findOne(['_id' => new ObjectID($id)]);

        // replace this example code with whatever you need
        return $this->render(':show:error.html.twig', [
            'error' => $error
        ]);
    }
}