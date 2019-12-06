<?php

namespace App\Controller;

use App\Repository\OeuvreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil.index")
     * @param OeuvreRepository $oeuvreRepository
     * @return Response
     */
    public function index(OeuvreRepository $oeuvreRepository)
    {
        $result = $oeuvreRepository->findAll();
        shuffle($result);
        $result = array_slice($result, 0, 4);
        return $this->render('accueil/index.html.twig', [
            'shuffledResult' => $result,
        ]);
    }
}
