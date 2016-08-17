<?php

namespace AppBundle\Controller;

use ONGR\ElasticsearchBundle\Result\Result;
use ONGR\ElasticsearchDSL\Query\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $results = $this->get('ongr_filter_manager.search_list')->handleRequest($request);
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'filter_manager' => $results
        ]);
    }

    /**
     * @Route("/details/{id}", name="details")
     */
    public function detailsAction($id)
    {
        $manager = $this->get('es.manager.default.error');
        $search = new Search();
        $search->addQuery(new TermQuery('_id', $id));
        $results = $manager->execute($search, Result::RESULTS_ARRAY);

        if (false === isset($results[0])) {
            throw new \InvalidArgumentException('Document not found');
        }

        return $this->render('default/detail.html.twig', [
            'error' => $results[0]
        ]);
    }
}
