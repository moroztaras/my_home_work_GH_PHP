<?php

namespace Blog\BlogBundle\Controller;

use Blog\BlogBundle\Entity\User;
use Blog\BlogBundle\Form\Type\UserType;
use Blog\BlogBundle\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Blog\BlogBundle\Consts;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    //метод реєстрації користувача
    public function registrationAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user, array('validation_groups' => array('registration')));

        $form->handleRequest($request);

        if($form->isValid()){
            try{
                $mng = $this->getDoctrine()->getManager();
                $mng->persist($user);
                $mng->flush();

                $status = Messages::SUCCESS;
            }catch (\Exception $e){
                $status = Messages::ERROR;
            }
        }else{
            $status = Messages::ERROR;
        }

        return $this->render("BlogBlogBundle::msgTemplate.html.twig", array('msg' => $status));

        //return new Response("<html><body>Ура, усе запрацювало!</body></html>");
    }
}