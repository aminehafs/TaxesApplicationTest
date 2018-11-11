<?php

namespace Fos\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class ListCategories extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'types',
                'Symfony\Component\Form\Extension\Core\Type\ChoiceType',
                array(
                    'choices' => array(
                        'Auto-entreprises' => 'companies',
                        'SAS' => 'sas'
                    )
                )
            )
            ->add(
                'submit',
                'Symfony\Component\Form\Extension\Core\Type\SubmitType',
                array('label' => 'Lancer la recherche')
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Fos\MainBundle\Form\Type\ListCategories',
            )
        );
    }
}