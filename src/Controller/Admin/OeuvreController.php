<?php

namespace App\Controller\Admin;

use App\Entity\Oeuvre;
use App\Form\OeuvreType;
use App\Repository\CategoryRepository;
use App\Repository\OeuvreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OeuvreController
 * @package App\Controller
 * @Route("/admin/oeuvres")
 */
class OeuvreController extends AbstractController
{
    /**
     * @Route("/", name="admin.oeuvre.index")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository):Response
    {
        $categories = $categoryRepository->findAll();


        return $this->render('admin/oeuvre/index.html.twig', [
            'categories' => $categories,
        ]);
    }


    /**
     * @Route("/form", name="admin.oeuvre.form")
     * @Route("/form/update/{id}", name="admin.oeuvre.form.update")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param int|null $id
     * @param OeuvreRepository $oeuvreRepository
     * @return Response
     */
public function form(Request $request, EntityManagerInterface $entityManager, int $id = null, OeuvreRepository $oeuvreRepository):Response
{
    $model = $id ? $oeuvreRepository->find($id) : new Oeuvre();
    $type = OeuvreType::class;
    $form = $this->createForm($type, $model);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $message = $model->getId() ? "L'oeuvre a été modifiée avec succès" : "L'oeuvre a été correctement ajoutée";

        $this->addFlash('notice', $message);

        $model->getId() ? null : $entityManager->persist($model);
        $entityManager->flush();

        return $this->redirectToRoute('admin.oeuvre.index');
    }

    return $this->render('admin/oeuvre/form.html.twig', [
        'form' => $form->createView()
    ]);
}

/**
     * @Route("/description/{id}",name="admin.oeuvre.remove", requirements={"id"="\d+"})
     * @param EntityManagerInterface $entityManager
     * @param OeuvreRepository $oeuvreRepository
     * @param int $id
     * @return Response
     */
    public function remove(EntityManagerInterface $entityManager, OeuvreRepository $oeuvreRepository, int $id): Response
    {
        $result = $oeuvreRepository->find($id);

        $entityManager->remove($result);
        $entityManager->flush();

        $this->addFlash('notice', "L'oeuvre a été supprimée");
        return $this->redirectToRoute('admin.oeuvre.index');
    }
}
