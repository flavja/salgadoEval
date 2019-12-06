<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Form\Model\ContactModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact.form")
     * @param Request $request
     * @return Response
     */
    public function form(Request $request):Response
    {
        $model = new ContactModel();
        $type = ContactType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);
        return $this->render('contact/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/mentionslegales", name="contact.mention")
     */
    public function mention():Response
    {
        return $this->render('contact/mentionslegales.html.twig');
    }
}
