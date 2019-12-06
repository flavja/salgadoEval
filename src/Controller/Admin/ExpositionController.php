<?php

namespace App\Controller\Admin;

use App\Repository\ExpositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/expositions")
 */
class ExpositionController extends AbstractController
{
    /**
     * @Route("/", name="admin.exposition.index")
     * @param ExpositionRepository $expositionRepository
     * @return Response
     */
    public function index(ExpositionRepository $expositionRepository)
    {
        $expositions = $expositionRepository->findAfterToday();
        $pastExpositions = $expositionRepository->findBeforeToday();
        return $this->render('admin/exposition/index.html.twig', [
            'expositions' => $expositions,
            'pastExpositions' => $pastExpositions
        ]);
    }
}
