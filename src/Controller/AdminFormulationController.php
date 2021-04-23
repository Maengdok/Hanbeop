<?php

namespace App\Controller;

use App\Entity\Formulation;
use App\Form\FormulationType;
use App\Repository\FormulationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/formulation")
 */
class AdminFormulationController extends AbstractController
{
    /**
     * @Route("/", name="admin_formulation_index", methods={"GET"})
     */
    public function index(FormulationRepository $formulationRepository): Response
    {
        return $this->render('Admin/admin_formulation/index.html.twig', [
            'formulations' => $formulationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_formulation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $formulation = new Formulation();
        $form = $this->createForm(FormulationType::class, $formulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formulation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_formulation_index');
        }

        return $this->render('Admin/admin_formulation/new.html.twig', [
            'formulation' => $formulation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_formulation_show", methods={"GET"})
     */
    public function show(Formulation $formulation): Response
    {
        return $this->render('Admin/admin_formulation/show.html.twig', [
            'formulation' => $formulation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_formulation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formulation $formulation): Response
    {
        $form = $this->createForm(FormulationType::class, $formulation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_formulation_index');
        }

        return $this->render('Admin/admin_formulation/edit.html.twig', [
            'formulation' => $formulation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_formulation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formulation $formulation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formulation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_formulation_index');
    }
}
