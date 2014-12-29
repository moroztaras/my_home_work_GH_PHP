<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\User;
use BlogBundle\Form\Type\UserType;
use BlogBundle\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SuperPuperController extends Controller
{
    public function showSpfAction(Request $request, $userId)
    {
        $user = isset($userId) ? $this->getDoctrine()->getRepository("BlogBundle:User")->find($userId) : new User();
        if ($user != null) {
            $form = $this->createForm(new UserType(), $user);
            $form->handleRequest($request);

            return $this->render("BlogBundle:SuperPuper:superPuper.html.twig", array(
                'form' => $form->createView()
            ));
        } else {
            return $this->render("BlogBundle::msgTemplate.html.twig", array('msg' => Messages::USER_NOT_FOUND));
        }
    }

    public function spfActAction(Request $request, $userId)
    {
        $user = isset($userId) ? $this->getDoctrine()->getRepository("BlogBundle:User")->find($userId) : new User();
        $oldPostsList = $user->getPosts();
        if ($user != null) {
            $form = $this->createForm(new UserType(), $user, array('validation_groups' => array('registration', 'login')));
            $form->handleRequest($request);
            if ($form->isValid()) {
                foreach ($oldPostsList as $oldPost) {
                    if(!$user->getPosts()->contains($oldPost)){
                        $this->getDoctrine()->getManager()->remove($oldPost);
                    }
                }
                foreach ($user->getPosts() as $post) {
                    $this->getDoctrine()->getManager()->persist($post);
                }
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();
                $status = Messages::SUCCESS;
            } else {
                $status = Messages::ERROR;
            }

            return $this->render("BlogBundle::jsonMsgTemplate.json.twig", array('msg' => $status));
        } else {
            return $this->render("BlogBundle::msgTemplate.html.twig", array('msg' => Messages::USER_NOT_FOUND));
        }
    }


}