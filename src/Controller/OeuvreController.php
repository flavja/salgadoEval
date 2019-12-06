<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\OeuvreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OeuvreController
 * @package App\Controller
 * @Route("/oeuvres")
 */
class OeuvreController extends AbstractController
{
    /**
     * @Route("/{catego}", name="oeuvre.index")
     * @param CategoryRepository $categoryRepository
     * @param string|null $catego
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository, ?string $catego = null):Response
    {
        $categories = $catego ? $categoryRepository->findBy([
            'name' => $catego
        ]) : $categoryRepository->findAll();


        return $this->render('oeuvre/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/description/{id}",name="oeuvre.details", requirements={"id"="\d+"})
     * @param OeuvreRepository $oeuvreRepository
     * @param int $id
     * @return Response
     */
    public function details(OeuvreRepository $oeuvreRepository, int $id): Response
    {
        $result = $oeuvreRepository->find($id);

        return $this->render('oeuvre/details.html.twig', [
            'result' => $result
    ]);
    }
}
