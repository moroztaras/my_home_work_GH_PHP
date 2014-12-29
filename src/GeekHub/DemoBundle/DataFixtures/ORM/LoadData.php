<?php
namespace GeekHub\DemoBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GeekHub\DemoBundle\Entity\Product;
use GeekHub\DemoBundle\Entity\User;
class LoadData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setUsername('User')
            ->setEmail('test@email.com')
        ;
        $manager->persist($user);

        $product1 = new Product();
        $product1
            ->setTitle('Php Book')
            ->setPrice(150)
        ;
        $manager->persist($product1);

        $product2 = new Product();
        $product2
            ->setTitle('Notebook')
            ->setPrice(7000)
        ;
        $manager->persist($product2);

        $product3 = new Product();
        $product3
            ->setTitle('Pen')
            ->setPrice(80)
        ;
        $manager->persist($product3);

        $product4 = new Product();
        $product4
            ->setTitle('Erlang Book')
            ->setPrice(50)
        ;
        $manager->persist($product4);
        $manager->flush();
    }
}