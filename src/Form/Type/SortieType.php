<?php

namespace App\Form\Type;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Sortie;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SortieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $em = $options['em'];
        $campuses = $em->getRepository(Campus::class)->findAll();

        $choices = [];
        foreach ($campuses as $campus) {
            $choices[$campus->getNom()] = $campus->getId();
        }

        $builder
            ->add('nom',TextType::class)
            ->add('dateHeureDebut',DateTimeType::class)
            ->add('duree',IntegerType::class)
            ->add('dateLimiteInscription',DateType::class)
            ->add('nbInscriptionsMax',IntegerType::class)
            ->add('infosSortie',TextType::class)
            ->add('lieu',EntityType::class, array(
                'class' => 'App\Entity\Lieu',
                "choice_label" => function ($allChoices)
                {
                    return $allChoices->getNom() . " " . $allChoices->getRue();
                }
            ))

            ->add('campus',EntityType::class, array(
                'class' => 'App\Entity\Campus',
                'choice_label' => 'nom'
            ))

            ->add('etat',EntityType::class, array(
            'class' => 'App\Entity\Etat',
            'choice_label' => 'libelle',
    ));
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class'=>Sortie::class,
            'em'=>null,
        ]);
    }

}