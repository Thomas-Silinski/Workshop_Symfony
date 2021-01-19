<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pseudo');
        $builder->add('bio');
        $builder->add('phone');
        $builder->add('inscriptionDate',
            DateType::class, array(
            'widget' => 'single_text',
            'input' => 'datetime',
        ));
        $builder->add('adressLine');
        $builder->add('city');
        $builder->add('zipCode');
        $builder->add('country');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'my_api_registration';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
           'data_class' => 'AppBundle\Entity\User',
           'csrf_protection' => false,
       ));
    }
}