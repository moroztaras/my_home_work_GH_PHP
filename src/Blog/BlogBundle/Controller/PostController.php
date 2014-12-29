<?php

namespace Blog\BlogBundle\Controller;

use Blog\BlogBundle\Entity\Post;
use Blog\BlogBundle\Form\Type\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Blog\BlogBundle\Lib\Searcher\Searcher;

class PostController extends Controller
{
    public function indexAction()
    {
        /*
        $t=$this->get('translator')->trans('Привіт, Тарасе!');
        return new Response ($t);
        */

        $manager=$this->getDoctrine()->getManager();

        //для отримання записі із оприділено сущності
        $posts=$this->getDoctrine()->getRepository('BlogBlogBundle:Post')->findBy([],['id'=>'DESC']);

        //вказуємо що повинен вітдаватися саме цей шаблон
        return $this->render('BlogBlogBundle:Post:index.html.twig', array('posts'=>$posts));

    }
    public function wordAction($word)
    {
        //отримати відповідь запиту
        $request=$this->getRequest();//отримання обєкту запиту
      //$request=isMethod('POST');//Перевірка чи насправді пришов запит через метод POST
        $param=$request->query->get('param'); //отримання параметру

        //return $this->render('BlogBlogBundle:Post:index.html.twig', array('name' => $name));
        //return new Response("<html><body>Hello $word! Ура, усе запрацювало!</body></html>");
        //return new Response("<html><body>$word with param $param</body></html>");

        //повернення Response в форматі json
       /* $response=new Response(json_encode("<html><body>$word with param $param</body></html>"));
        $response->headers->set('Content-Type','application/json');
        return $response;
       */
        return $this->render('BlogBlogBundle:Post:word.html.twig', array('word' => $word,'param'=>$param));
    }
    //метод який вивдить одну вибранну статтю
    public function showAction($postId){
        $manager=$this->getDoctrine()->getManager();
        $post=$manager->getRepository('BlogBlogBundle:Post')->find($postId);
       /*
        //отримання repository Post
        $repository=$this->getDoctrine()
            ->getRepository('BlogBlogBundle:Post');
        //отримання переданого індефікатора
        $query=$repository->createQueryBuilder('p')
            ->where('p.id=:id')
            ->setParameter('id',$postId)
            ->getQuery();

        //отримання одного результату від запиту
        $post=$query->getSingleResult();
        */

        //кількість переглядів
        $counter=$post->getCounter();
        $post->setCounter($counter+1);

        $manager->flush();

        return $this->render('BlogBlogBundle:Post:show.html.twig', array('post'=>$post));
    }

    //метод для пошука
    public function searchPostAction()
    {
        //створення обєкту цього класу
        //$searcher=new Searcher();

        $searcher=$this->get('searcher');//отримання за дапомогою контейнера
        //метод get - придостовляєт доступ к контейнеру сервесов
        $result=$searcher->search($this->getRequest()->request->get('search'));

        //отримання repository Post
        $repository=$this->getDoctrine()->getRepository('BlogBlogBundle:Post');

        //конструктор запиту
        //отримання переданого індефікатора
        $query=$repository->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids',$result)
            ->getQuery();

        //отримання всі результати
        $posts=$query->getResult();
        //$posts=$this->getDoctrine()->getRepository('BlogBlogBundle:Post')->findAll();//отримання усіх результатів

        return $this->render('BlogBlogBundle:Post:index.html.twig', array('posts'=>$posts));
    }

    //метод добавлення нової записі в БД
    public function newAction(Request $request){
        //модель
        $post= new Post();
        $post->setPostedDateToCurrent();//дата
        //визиваємо метод createForm і передаємо в його наш клас PostType()
        $form=$this->createForm(new PostType(),$post);

        // обработать наш request який до нас прийшов
        $form->handleRequest($request);//перевірка засабмітилася форма чи ні

        //перевірка на валідность
        if ($form->isValid()){
            $maneger=$this->getDoctrine()->getManager();
            $post->setCounter();//кількість
            $maneger->persist($post);
            $maneger->flush();

            return $this->redirect(($this->generateUrl('blog_index')));
        }else{
            return $this->render('BlogBlogBundle:Post:new.html.twig',array('form'=>$form->createView()));
        }
    }

    //метод видалення записі з БД
    public function delPostAction ($postId){
        $maneger=$this->getDoctrine()->getManager();
        $post=$maneger->getRepository('BlogBlogBundle:Post')->find($postId);
        $maneger->remove($post);
        $maneger->flush();
        return $this->redirect(($this->generateUrl('blog_index')));
    }

    //метод редагування записі в БД через форму
    public function showEditPostFormAction (Request $request, $postId){
        $post= new Post();
        $manager=$this->getDoctrine()->getManager();
        $post=$manager->getRepository('BlogBlogBundle:Post')->find($postId);

        //визиваємо метод createForm і передаємо в його наш клас PostType()
        $form=$this->createForm(new PostType(),$post);

        $form->handleRequest($request);
        //перевірка на валідность
        if ($form->isValid()){
            $manager->persist($post);
            $manager->flush();
            return $this->redirect(($this->generateUrl('blog_index')));
        }else{
            return $this->render('BlogBlogBundle:Post:edit.html.twig',array('form'=>$form->createView(),'id'=>$postId,'post'=>$post));
        }
    }


}
