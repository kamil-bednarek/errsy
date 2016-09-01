<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Controller;

use ONGR\ElasticsearchBundle\Result\Result;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller
{
    /**
     * @Route("/list", name="list")
     */
    public function indexAction(Request $request)
    {
        $results = $this->get('ongr_filter_manager.search_list')->handleRequest($request);
        
        
        $this->get('erkam.search.service')->searchException('for array with keys');
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'filter_manager' => $results
        ]);
    }
}
