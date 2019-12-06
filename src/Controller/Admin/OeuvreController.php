<?php

namespace App\Controller\Admin;

use App\Repository\CategoryRepository;
use App\Repository\OeuvreRepository;
use App\Service\FileService;
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
     * @Route("/{catego}", name="admin.oeuvre.index")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository):Response
    {
        $categories = $categoryRepository->findAll();


        return $this->render('oeuvre/index.html.twig', [
            'categories' => $categories,
        ]);
    }

}

/**
 * @Route("/form", name="admin.product.form")
 * @Route("/form/update/{id}", name="admin.product.form.update")
 */
public function form(Request $request, EntityManagerInterface $entityManager, int $id = null, OeuvreRepository $oeuvreRepository):Response
{
    // si l'id est nul, une insertion est exécutée, sinon une modification est exécutée
    $model = $id ? $oeuvreRepository->find($id) : new Oeuvre();
    $type = OeuvreType::class;
    $form = $this->createForm($type, $model);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        //dd($form->getData());

        // message de confirmation
        $message = $model->getId() ? "Le produit a été modifié" : "Le produit a été ajouté";

        // message stocké en session
        $this->addFlash('notice', $message);

        /*
         * insertion dans la base de données
         *  - persist: méthode déclenchée uniquement lors d'une insertion
         *  - lors d'une mise à jour, aucune méthode n'est requise
         *  - remove: méthode déclenchée uniquement lors d'une suppression
         *  - flush: exécution des requêtes SQL
         */
        $model->getId() ? null : $entityManager->persist($model);
        $entityManager->flush();

        // redirection
        return $this->redirectToRoute('admin.product.index');
    }

    return $this->render('admin/product/form.html.twig', [
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

        // message et redirection
        $this->addFlash('notice', "Le produit a été supprimé");
        return $this->redirectToRoute('admin.oeuvre.index');
    }
}
