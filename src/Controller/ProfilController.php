<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\Type\ParticipantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function profil(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $participant = new Participant();

        /**$participant->setPrenom('Alice');
        $participant->setPseudo(getUser()->getPseudo());
        $participant->setPrenom(getPrenom());
        $participant->setNom(getNom());
        $participant->setTelephone(getTelephone());
        $participant->setMail(getMail());
        $participant->setCampus(getCampus());
*/




        $form = $this->createForm(ParticipantType::class, $participant, [
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();
            $participant->setMotPasse(
                $userPasswordHasher->hashPassword(
                    $participant,
                    $form->get('motPasseTexte')->getData()
                )
            );

            $entityManager->persist($participant);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('profil.html.twig', array(
            'form' => $form->createView()
        ));
    }




    #[Route('/creation-profil', name: 'app_creation_profil')]
    public function newAction(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant, [
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant = $form->getData();
            $participant->setMotPasse(
            $userPasswordHasher->hashPassword(
                    $participant,
                    $form->get('motPasseTexte')->getData()
                )
            );

            $entityManager->persist($participant);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('profil/newProfil.html.twig', array(
            'form' => $form->createView()
        ));
    }
}