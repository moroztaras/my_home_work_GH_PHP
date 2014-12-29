<?php

namespace GeekHub\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OrderController extends Controller
{
    private $orders = array(
        1 => array(
            'number'   => '2695234',
            'products' => array(1,2,3),
            'price'    => 7200
        ),
        2 => array(
            'number'   => '5305935',
            'products' => array(2,4),
            'price'    => 7050
        ),
    );

    /**
     * @Route("/", name="order_list")
     * @Template()
     */
    public function indexAction()
    {
        return array('orders' => $this->orders);
    }

    /**
     * @Route("/order/{id}", name="order_detail")
     * @Template()
     */
    public function orderDetailsAction($id)
    {

    }
}
