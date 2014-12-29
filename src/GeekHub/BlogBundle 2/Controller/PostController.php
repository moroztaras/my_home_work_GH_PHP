<?php

namespace BlogBundle\Controller;

use BlogBundle\Consts;
use BlogBundle\Entity\Post;
use BlogBundle\Form\Type\PostType;
use BlogBundle\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class PostController extends Controller
{
    public function showUsersPostsAction($login)
    {
        $user = $this->getDoctrine()->getRepository("BlogBundle:User")->findOneBy(array('login' => $login));
        if($user != null){

            return $this->render("BlogBundle:Post:postList.html.twig", array('postOwner' => $user, 'postList' => $user->getPosts()->toArray()));
        }else{
            $resp = new Response(Messages::NOT_FOUND);
            $resp->setStatusCode(404);

            return $resp;
        }
    }

    public function editPostAction(Request $request, $postId)
    {
        $loginedUser = $request->getSession()->get(Consts::USER_PARAM_NAME);
        if ($loginedUser != null) {
            $user = $this->getDoctrine()->getRepository("BlogBundle:User")->find($loginedUser->getId());
            $post = $user->getPostById($postId);
            if ($post != null) {
                $form = $this->createForm(new PostType(), $post);
                $form->handleRequest($request);
                $this->getDoctrine()->getManager()->flush();
                $status = Messages::SUCCESS;
            } else {
                $status = Messages::ERROR;
            }
        } else {
            $status = Messages::ERROR;
        }

        return $this->render("BlogBundle::jsonMsgTemplate.json.twig", array('msg' => $status));
    }

    public function addPostAction(Request $request){
        $loginedUser = $request->getSession()->get(Consts::USER_PARAM_NAME);
        if ($loginedUser != null) {
            $post = new Post();
            $form = $this->createForm(new PostType(), $post);
            $form->handleRequest($request);
            $user = $this->getDoctrine()->getRepository("BlogBundle:User")->find($loginedUser->getId());
            $user->addPost($post);
            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            $status = Messages::SUCCESS;
        } else {
            $status = Messages::ERROR;
        }

        return $this->render("BlogBundle::jsonMsgTemplate.json.twig", array('msg' => $status));
    }

    public function delPostAction(Request $request, $postId)
    {
        $loginedUser = $request->getSession()->get(Consts::USER_PARAM_NAME);
        if ($loginedUser != null) {
            $user = $this->getDoctrine()->getRepository("BlogBundle:User")->find($loginedUser->getId());
            $post = $user->getPostById($postId);
            if ($post != null) {
                $this->getDoctrine()->getManager()->remove($post);
                $user->removePost($post);
                $this->getDoctrine()->getManager()->flush();
                $status = Messages::SUCCESS;
            }else{
                $status = Messages::ERROR;
            }
        }else{
            $status = Messages::ERROR;
        }

        return $this->render("BlogBundle::jsonMsgTemplate.json.twig", array('msg' => $status));
    }

    public function showAddPostFormAction(Request $request)
    {
        $loginedUser = $request->getSession()->get(Consts::USER_PARAM_NAME);
        if ($loginedUser != null) {

            return $this->render("BlogBundle:Post:editPostForm.html.twig", array(
                'form' => $this->createForm(new PostType())->createView()
            ));
        } else {
            return new RedirectResponse($this->get('router')->generate('login'));
        }
    }

    public function showEditPostFormAction(Request $request, $postId)
    {
        $loginedUser = $request->getSession()->get(Consts::USER_PARAM_NAME);
        if ($loginedUser != null) {
            $user = $this->getDoctrine()->getRepository("BlogBundle:User")->find($loginedUser->getId());
            $post = $user->getPostById($postId);
            if ($post == null) {
                return $this->render("BlogBundle::msgTemplate.html.twig", array('msg' => Messages::POST_NOT_FOUND));
            }
            $form = $this->createForm(new PostType(), $post);
            $form->handleRequest($request);

            return $this->render("BlogBundle:Post:editPostForm.html.twig", array(
                'form' => $form->createView()
            ));
        } else {
            return new RedirectResponse($this->get('router')->generate('login'));
        }
    }

}