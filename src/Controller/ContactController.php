<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactFormType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $name = $form['name']->getData();
            $email = $form['email']->getData();
            $subject = $form['subject']->getData();
            $message = $form['message']->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            
            $contactMessage = (new \Swift_Message($subject))
            ->setFrom($email)
            ->setTo('axel.pion@maengdok.fr')
            ->setBody('Sender :'.$name. " - " .$email.\PHP_EOL.$message, 'text/plain');
            $mailer->send($contactMessage);
            
            $this->addFlash('contact_success', 'Votre message a bien été envoyé');

            return $this->redirectToRoute('contact');
        }


        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
