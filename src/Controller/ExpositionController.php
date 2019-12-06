<?php

namespace App\Controller;

use App\Repository\ExpositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/expositions")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/", name="exposition.index")
     * @param ExpositionRepository $expositionRepository
     * @return Response
     */
    public function index(ExpositionRepository $expositionRepository)
    {
        $expositions = $expositionRepository->findAfterToday();
        $pastExpositions = $expositionRepository->findBeforeToday();
        return $this->render('exposition/index.html.twig', [
            'expositions' => $expositions,
            'pastExpositions' => $pastExpositions
        ]);
    }
}
