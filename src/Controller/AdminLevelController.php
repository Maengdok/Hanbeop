<?php

namespace App\Controller;

use App\Entity\Level;
use App\Form\LevelType;
use App\Repository\LevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/level")
 */
class AdminLevelController extends AbstractController
{
    /**
     * @Route("/", name="admin_level_index", methods={"GET"})
     */
    public function index(LevelRepository $levelRepository): Response
    {
        return $this->render('Admin/admin_level/index.html.twig', [
            'levels' => $levelRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_level_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $level = new Level();
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($level);
            $entityManager->flush();

            return $this->redirectToRoute('admin_level_index');
        }

        return $this->render('Admin/admin_level/new.html.twig', [
            'level' => $level,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_level_show", methods={"GET"})
     */
    public function show(Level $level): Response
    {
        return $this->render('Admin/admin_level/show.html.twig', [
            'level' => $level,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_level_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Level $level): Response
    {
        $form = $this->createForm(LevelType::class, $level);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_level_index');
        }

        return $this->render('Admin/admin_level/edit.html.twig', [
            'level' => $level,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_level_delete", methods={"POST"})
     */
    public function delete(Request $request, Level $level): Response
    {
        if ($this->isCsrfTokenValid('delete'.$level->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($level);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_level_index');
    }
}
