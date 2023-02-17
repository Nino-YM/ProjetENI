<?php

namespace App\Form\Type;

use App\Data\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q', TextType::class, [
                'label'=>false,
                'required'=>false,
                'attr'=> [
                    'placeholder'=>'Rechercher'
                ]
            ])
            ->add('categories', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => 'App\Entity\Campus',
                'choice_label' => 'nom'
            ])


            ->add('datemin',DateType::class, [
                'label'=> false,
                'required'=> false,
            ])
            ->add('datemax',DateType::class, [
                'label'=> false,
                'required'=> false,
            ])
            ->add('orga',CheckboxType::class, [
                'label'=> "Sorties dont je suis l'organisateur/trice",
                'required'=> false,
            ])
            ->add('inscrit',CheckboxType::class, [
                'label'=> 'Sorties auxquelles je suis Inscrit(e)',
                'required'=> false,
            ])
            ->add('noninscrit',CheckboxType::class, [
                'label'=> 'Sorties auxquelles je ne suis pas inscrit(e)',
                'required'=> false,
            ])
            ->add('passe',CheckboxType::class, [
                'label'=> 'Sorties passées',
                'required'=> false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method'=>'GET',
            'csrf_protection' =>false
        ])
        ;
    }


    public function getBlockPrefix()
    {
        return '';
    }


}