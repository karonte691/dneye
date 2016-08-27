<?php

namespace AppBundle\Controller;


use AppBundle\Document\SearchStorage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\SearchForm;
use AppBundle\Document\Item;

class SearchController extends Controller
{
    /**
     * search module
     * This method will search the item on db. If the item does not exist, it schedule the discover job and return 0 results.
     * Once the job is executed, it will send a item discover request to imdb api
     *
     * @param Request $request
     */
    public function searchAction(Request $request)
    {
        $item = new Item();

        $form = $this->createForm(SearchForm::class, $item, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $item = $form->getData();

            $itemRepository = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Item');

            $search_results = $itemRepository->searchByTitle($item);


            if(count($search_results) == 0)
            {
                /*
                 *  This will be send the discover job module to gearman server.
                 *  This is a main part of dneye but it isn't fully tested yet and there is still some error on launch
                 *  For this reason, we will use a sync operation for now
                 *

                $gearman = $this->get('gearman');

                $gearman->doBackgroundJob('AppBundleServicesItemProcessor~test', json_encode(['sTerm' => $item->getTitle()]));
                */

                $discover = $this->get('background_worker');

                $discover->processItem($item->getTitle());

            }

            return $this->render('search/search.html.twig', [
                'search_form' => $form->createView(),
                'search_results' => $search_results,
                'search_term' => $item->getTitle()
            ]);
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }
    }


    /**
     * Search form block
     * This block is rendered by "render" twig tag in every page.
     * The form builder is in Form\SearchForm
     */
    public function searchFormAction()
    {
        $item = new Item();

        $form = $this->createForm(SearchForm::class, $item, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));

        return $this->render('form/search.form.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'search_form' => $form->createView(),
        ]);
    }


}