<?php

namespace GeekHub\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductController extends Controller
{
    /**
     * @Route("/products/{max}")
     * @Template()
     */
    public function indexAction($max = 3)
    {
        $products = $this->getProductRepository()->findBy(array(), array('createdAt' => 'ASC'), $max);

        return array('products' => $products);
    }

    /**
     * @return EntityManager
     */
    protected function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return EntityRepository
     */
    protected function getProductRepository()
    {
        return $this->getEm()->getRepository('GeekHubDemoBundle:Product');
    }
}