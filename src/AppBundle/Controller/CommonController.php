<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommonController extends Controller
{

    /**
     *  Nothing to say here. About page...
     *
     */
    public function aboutAction(Request $request)
    {
        return $this->render('default/about.html.twig',[]);
    }

    /**
     *  Nothing to say here. contact page...
     *
     */
    public function contactAction(Request $request)
    {
        return $this->render('default/contact.html.twig',[]);
    }

}