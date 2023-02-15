<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\SortieType;
use Symfony\Component\HttpFoundation\Response;

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
}