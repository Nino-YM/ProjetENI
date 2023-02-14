<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CampusController extends AbstractController
{
    #[Route('/campus', name: 'app_campus')]
    public function campus(): Response
    {
        return $this->render('campus.html.twig', []);
    }
}