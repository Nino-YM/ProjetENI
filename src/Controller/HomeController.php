<?php

namespace App\Controller;

use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $infos = $doctrine->getRepository(Sortie::class)->findAll();

        if (!$infos) {
            throw $this->createNotFoundException(
                "Pas d'information trouvé "
            );
        }

        return $this->render('home.html.twig', ['infos'=>$infos]);
    }

    /**
     * @Route("/inscription/{activityId}", name="inscription", methods={"POST"}, options={"expose"=true})
     */
    public function inscription(Request $request, $activityId, EntityManagerInterface $entityManager)
    {
        $activity = $entityManager->getRepository(Sortie::class)->find($activityId);
        $user = $this->getUser();

        if ($activity->getParticipants()->contains($user)) {
            return new JsonResponse(['status' => 'error', 'message' => 'User already registered.']);
        }

        $activity->addParticipant($user);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success']);
    }


}
