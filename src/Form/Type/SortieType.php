<?php

namespace App\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Sortie;


class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('dateHeureDebut', DateType::class)
            ->add('duree', TextType::class)
            ->add('dateLimiteInscription', DateType::class)
            ->add('nbInscriptionsMax', NumberType::class)
            ->add('infosSortie', TextType::class)
            ->add('lieu', EntityType::class, array(
                'class' => 'App\Entity\Lieu',
                'choice_label' => 'nom'
            ))
            ->add('etat', EntityType::class, array(
                'class' => 'App\Entity\Etat',
                'choice_label' => 'libelle'
            ))
            ->add('campus', EntityType::class, array(
                'class' => 'App\Entity\Campus',
                'choice_label' => 'nom'
            ))
           // ->add('latitude', TextType::class,['mapped' => false])
           // ->add('longitude', TextType::class,['mapped' => false])

            ->add('save', SubmitType::class);
    }
        public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }

}