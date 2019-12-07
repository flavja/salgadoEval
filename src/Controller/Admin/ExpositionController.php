<?php

namespace App\Controller\Admin;

use App\Entity\Exposition;
use App\Form\ExpositionType;
use App\Repository\ExpositionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/form", name="admin.exposition.form")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ExpositionRepository $expositionRepository
     * @return Response
     */
    public function form(Request $request, EntityManagerInterface $entityManager, ExpositionRepository $expositionRepository):Response
    {

        $model = new Exposition();
        $type = ExpositionType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $this->addFlash('notice', "L'exposition a été ajoutée");
            $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('admin.exposition.index');
        }

        return $this->render('admin/exposition/form.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
