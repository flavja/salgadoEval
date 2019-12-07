<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccueilController
 * @package App\Controller\Admin
 * @Route("/admin")
 */
class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="admin.accueil.index")
     * @return Response
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
}
