<?php

namespace Blog\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\BlogBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    /*
     * {@inheritDoc}
     */
    public function Load(ObjectManager $manager){
        $post= new Post();//створення обєкта Post
        //заповнюємо обєкт даними
        $post->setTitle('Заголовок статті');
        $post->setContent('Текст статті');
        $post->setAuthor('Мороз Тарас');

        //робимо вставку в базу даних
        $manager->persist($post);
        $manager->flush();
    }

}