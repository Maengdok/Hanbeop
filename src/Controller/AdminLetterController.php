<?php

namespace App\Controller;

use App\Entity\Letter;
use App\Form\LetterType;
use App\Repository\LetterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/letter")
 */
class AdminLetterController extends AbstractController
{
    /**
     * @Route("/", name="admin_letter_index", methods={"GET"})
     */
    public function index(LetterRepository $letterRepository): Response
    {
        return $this->render('Admin/admin_letter/index.html.twig', [
            'letters' => $letterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_letter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $letter = new Letter();
        $form = $this->createForm(LetterType::class, $letter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($letter);
            $entityManager->flush();

            return $this->redirectToRoute('admin_letter_index');
        }

        return $this->render('Admin/admin_letter/new.html.twig', [
            'letter' => $letter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_letter_show", methods={"GET"})
     */
    public function show(Letter $letter): Response
    {
        return $this->render('Admin/admin_letter/show.html.twig', [
            'letter' => $letter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_letter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Letter $letter): Response
    {
        $form = $this->createForm(LetterType::class, $letter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_letter_index');
        }

        return $this->render('Admin/admin_letter/edit.html.twig', [
            'letter' => $letter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_letter_delete", methods={"POST"})
     */
    public function delete(Request $request, Letter $letter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$letter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($letter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_letter_index');
    }
}
