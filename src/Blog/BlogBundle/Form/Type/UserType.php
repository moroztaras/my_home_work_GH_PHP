<?php

namespace Blog\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', 'text')
            ->add('openPass', 'password', array('label' => 'pass'))
            ->add('email', 'text')
            ->add('posts', 'collection', array(
                'type' => new PostType(),
                'allow_add' => true,
                'allow_delete' => true
            ))
            ->add('ok', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\User',
            'csrf_protection' => true,
            'csrf_field_name' => '_token'
        ));
    }

    public function getName()
    {
        return "userForm";
    }
}