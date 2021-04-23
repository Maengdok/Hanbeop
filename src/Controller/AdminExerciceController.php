<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Form\ExerciceType;
use App\Repository\ExerciceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/exercice")
 */
class AdminExerciceController extends AbstractController
{
    /**
     * @Route("/", name="admin_exercice_index", methods={"GET"})
     */
    public function index(ExerciceRepository $exerciceRepository): Response
    {
        return $this->render('Admin/admin_exercice/index.html.twig', [
            'exercices' => $exerciceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_exercice_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $exercice = new Exercice();
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($exercice);
            $entityManager->flush();

            return $this->redirectToRoute('admin_exercice_index');
        }

        return $this->render('Admin/admin_exercice/new.html.twig', [
            'exercice' => $exercice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_exercice_show", methods={"GET"})
     */
    public function show(Exercice $exercice): Response
    {
        return $this->render('Admin/admin_exercice/show.html.twig', [
            'exercice' => $exercice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_exercice_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Exercice $exercice): Response
    {
        $form = $this->createForm(ExerciceType::class, $exercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_exercice_index');
        }

        return $this->render('Admin/admin_exercice/edit.html.twig', [
            'exercice' => $exercice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_exercice_delete", methods={"POST"})
     */
    public function delete(Request $request, Exercice $exercice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$exercice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($exercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_exercice_index');
    }
}
