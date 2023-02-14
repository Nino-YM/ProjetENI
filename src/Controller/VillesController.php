<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VillesController extends AbstractController
{
    #[Route('/villes', name: 'app_villes')]
    public function villes(): Response
    {
        return $this->render('villes.html.twig', []);
    }
}