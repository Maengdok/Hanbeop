<?php

namespace App\Controller;

use App\Entity\Meaning;
use App\Form\MeaningType;
use App\Repository\MeaningRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/meaning")
 */
class AdminMeaningController extends AbstractController
{
    /**
     * @Route("/", name="admin_meaning_index", methods={"GET"})
     */
    public function index(MeaningRepository $meaningRepository): Response
    {
        return $this->render('Admin/admin_meaning/index.html.twig', [
            'meanings' => $meaningRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_meaning_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $meaning = new Meaning();
        $form = $this->createForm(MeaningType::class, $meaning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($meaning);
            $entityManager->flush();

            return $this->redirectToRoute('admin_meaning_index');
        }

        return $this->render('Admin/admin_meaning/new.html.twig', [
            'meaning' => $meaning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_meaning_show", methods={"GET"})
     */
    public function show(Meaning $meaning): Response
    {
        return $this->render('Admin/admin_meaning/show.html.twig', [
            'meaning' => $meaning,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_meaning_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Meaning $meaning): Response
    {
        $form = $this->createForm(MeaningType::class, $meaning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_meaning_index');
        }

        return $this->render('Admin/admin_meaning/edit.html.twig', [
            'meaning' => $meaning,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_meaning_delete", methods={"POST"})
     */
    public function delete(Request $request, Meaning $meaning): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meaning->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($meaning);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_meaning_index');
    }
}
