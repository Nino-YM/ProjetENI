<?php

namespace App\Form\Type;

use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom', 'required'=> true])
            ->add('prenom', TextType::class, ['label' => 'Prénom', 'required'=> true])
            ->add('telephone', TextType::class, ['label' => 'Téléphone', 'required'=> true])
            ->add('mail', EmailType::class, ['label' => 'Email', 'required'=> true])
            ->add('pseudo', TextType::class, ['label' => 'Pseudo', 'required'=> true])
            ->add('motPasseTexte', PasswordType::class, [
                'mapped'=>false,
                'attr'=>['autocomplete'=>'new-password'],
                'label' => 'Mot de passe',
                'required'=> true,
                'constraints'=>[
                    new Length([
                        'min'=>6,
                        'minMessage'=>'Votre mot de passe doit avoir au moins 6  caractères',
                        'max'=>13,
                    ]),
                    ]]
                    )
            ->add('administrateur', IntegerType::class, ['label' => 'Administrateur'])
            ->add('actif', IntegerType::class, ['label' => 'Actif'])
            ->add('campus', EntityType::class, array(
                'class' => 'App\Entity\Campus',
                'choice_label' => 'nom',
            ))
            // ->add('campus', EntityType::class, ['label' => 'Campus', 'required'=> true])
            // ->add('sorties')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
