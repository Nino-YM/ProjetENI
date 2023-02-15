<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\SortieType;
use Doctrine\Persistence\ManagerRegistry;

class SortieController extends AbstractController
{
    #[Route('/creation-sortie', name: 'app_creation_sortie')]
    public function newAction(EntityManagerInterface $em, Request $request, ManagerRegistry $doctrine)
    {
        $form = $this->createForm(SortieType::class, null, [
            'em' => $doctrine->getManager(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sortie = $form->getData();

            $sortie->setOrganiseePar($this->getUser());

            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('sortie/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
}