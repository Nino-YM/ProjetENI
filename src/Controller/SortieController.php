<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\SortieType;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Sortie;

class SortieController extends AbstractController
{
    #[Route('/creation-sortie', name: 'app_creation_sortie')]
    public function newAction(EntityManagerInterface $entityManager, Request $request) :Response
    {
        $form = $this->createForm(SortieType::class, null, [
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sortie = $form->getData();

            $sortie->setOrganiseePar($this->getUser());

            $entityManager->persist($sortie);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('sortie/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    #[Route('/sortie/{id}', name: 'app_detail_sortie')]
    public function detailAction(Sortie $sortie) :Response
    {
        return $this->render('sortie/detail.html.twig', array(
            'sortie' => $sortie
        ));
    }

    #[Route('/sortie/inscription/{id}', name: 'app_inscription_sortie')]
    public function inscriptionAction(Sortie $sortie, EntityManagerInterface $entityManager) :Response
    {
        $sortie->addParticipant($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->render('sortie/inscription.html.twig');
    }

    #[Route('/sortie/desinscription/{id}', name: 'app_desinscription_sortie')]
    public function desinscriptionAction(Sortie $sortie, EntityManagerInterface $entityManager) :Response
    {
        $sortie->removeParticipant($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->render('sortie/desinscription.html.twig');
    }
}