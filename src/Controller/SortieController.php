<?php

namespace App\Controller;

use App\Form\Type\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sortie;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;



class SortieController extends AbstractController
{
    #[Route('/creation-sortie', name: 'app_creation_sortie')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sortie = new Sortie();
        $form = $this->createForm(SortieType::class, $sortie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $sortie = $form->getData();
            $sortie->setOrganiseePar($this->getUser());
            $entityManager->persist($sortie);
            $entityManager->flush();

            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('app_creation_sortie');
        }

        return $this->render('sortie/new.html.twig', [
            'form' => $form->createView(),
            ]);
    }





}


