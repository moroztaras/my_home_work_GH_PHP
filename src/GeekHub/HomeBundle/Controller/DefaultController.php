<?php

namespace GeekHub\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
       // return $this->render('GeekHubHomeBundle:Default:index.html.twig', array('name' => $name));
        return $this->render('GeekHubHomeBundle:Order:index.html.twig', array('name' => $name));
    }
}
