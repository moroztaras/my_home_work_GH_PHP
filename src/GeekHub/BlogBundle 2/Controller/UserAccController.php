<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\User;
use BlogBundle\Form\Type\UserType;
use BlogBundle\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use BlogBundle\Consts;
use Symfony\Component\HttpFoundation\Session\Session;

class UserAccController extends Controller
{

    public function showRegistrationFormAction(Request $request)
    {
        $form = $this->createForm(new UserType());
        return $this->render("BlogBundle:UserAcc:regForm.html.twig", array('form' => $form->createView()));
    }

    public function registerAction(Request $request)
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

        return $this->render("BlogBundle::msgTemplate.html.twig", array('msg' => $status));
    }

    public function showLoginFormAction()
    {
        $form = $this->createForm(new UserType());
        return $this->render("BlogBundle:UserAcc:authForm.html.twig", array("form" => $form->createView()));
    }

    public function loginAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);

        $form->handleRequest($request);

        $ur = $this->getDoctrine()->getRepository("BlogBundle:User");
        $user = $ur->findOneBy(array(
            "login" => $user->getLogin(),
            "pass" => $user->getPass()
        ));

        if ($user != null) {
            $request->getSession()->set(Consts::USER_PARAM_NAME, $user);
            $status = Messages::SUCCESS;
        } else {
            $status = Messages::ERROR;
        }

        return $this->render("BlogBundle::msgTemplate.html.twig", array('msg' => $status));
    }

    public function logoutAction(Request $request)
    {
        $request->getSession()->remove(Consts::USER_PARAM_NAME);

        return $this->render("BlogBundle::msgTemplate.html.twig", array('msg' => Messages::SUCCESS));
    }
}