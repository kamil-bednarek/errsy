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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ListErrorController extends Controller
{
    private function getDataProvider()
    {
        return $this->get('mongodb_provider')->getCollection('error');
    }

    private function getDataForChoice($field) {
        $choicesAppTmp = $this->getDataProvider()->distinct($field);
        $choicesApp = [];
        foreach ($choicesAppTmp as $choice) {
            $choicesApp[$choice] = $choice;
        }
        unset($choicesAppTmp);

        return $choicesApp;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function listAction(Request $request)
    {
        $data = [];

        $form = $this->createFormBuilder($data)
            ->setMethod('GET')
            ->add('message', TextType::class, [
                'required' => false
            ])
            ->add('app', ChoiceType::class, [
                'choices' => $this->getDataForChoice('app'),
                'multiple' => true,
                'required' => false
            ])
            ->add('env', ChoiceType::class, [
                'choices' => $this->getDataForChoice('env'),
                'multiple' => true,
                'required' => false
            ])
            ->add('method', ChoiceType::class, [
                'choices' => $this->getDataForChoice('method'),
                'multiple' => true,
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'button'],
                'label' => 'Search'
            ]);

        $searching = $form->getForm();
        $searching->handleRequest($request);

        $query = new MongoDBQuery('error');
        $query->setQuery([]);
        $query->setSort(['occurred.date' => -1]);

        $queryData = [];
        if (true === $searching->isSubmitted()) {
            $queryData = $searching->getData();
            $queryMongo = [];

            $form->setData($queryData);

            if (mb_strlen($queryData['message']) > 0) {
                $queryMongo['message'] = ['$regex' => $queryData['message']];
            }

            if (0 < count($queryData['app'])) {
                $queryMongo['app'] = [];
                $queryMongo['app'] = ['$in' => $queryData['app']];
            }

            if (0 < count($queryData['env'])) {
                $queryMongo['env'] = [];
                $queryMongo['env'] = ['$in' => $queryData['env']];
            }

            if (0 < count($queryData['method'])) {
                $queryMongo['method'] = [];
                $queryMongo['method'] = ['$in' => $queryData['method']];
            }

            $query->setQuery($queryMongo);
        }

        $paginator = $this->get('knp_paginator');
        $errors = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            25
        );
        
        // replace this example code with whatever you need
        return $this->render(':list:error.html.twig', [
            'errors' => $errors,
            'filters' => $form->getForm()->createView(),
            'searching' => $queryData
        ]);
    }
}
