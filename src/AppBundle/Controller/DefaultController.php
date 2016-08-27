<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * Home controller
     *
     * - latest_home_number is in parameters.yml file
     */
    public function indexAction()
    {
            $itemRepository = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Item');

            $limitHomeQuery = $this->container->getParameter('latest_home_number');

            if(!$limitHomeQuery)
                $limitHomeQuery = 10;

            $latest_item = $itemRepository->getLatestItem($limitHomeQuery);

            return $this->render('default/index.html.twig', [
                'latests' => $latest_item
            ]);
    }
}
