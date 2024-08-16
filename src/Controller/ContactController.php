<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/form', name: 'contact_page', methods:["GET", "POST"])]
    public function ContactForm(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('confirm_contact_page');
        }
        return $this->render('contact/contactFormhtml.twig', [
            'contactForm' => $form,
        ]);
    }

    #[Route('/contact/confirm', name:"confirm_contact_page")]
    public function contactConfirm():Response 
    {
        return $this->render('contact/contactConfirm.html.twig');
    }
}
