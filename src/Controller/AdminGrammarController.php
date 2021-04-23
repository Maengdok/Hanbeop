<?php

namespace App\Controller;

use App\Entity\Grammar;
use App\Form\GrammarType;
use App\Repository\GrammarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/grammar")
 */
class AdminGrammarController extends AbstractController
{
    /**
     * @Route("/", name="admin_grammar_index", methods={"GET"})
     */
    public function index(GrammarRepository $grammarRepository): Response
    {
        return $this->render('Admin/admin_grammar/index.html.twig', [
            'grammars' => $grammarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_grammar_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $grammar = new Grammar();
        $form = $this->createForm(GrammarType::class, $grammar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($grammar);
            $entityManager->flush();

            return $this->redirectToRoute('admin_grammar_index');
        }

        return $this->render('Admin/admin_grammar/new.html.twig', [
            'grammar' => $grammar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_grammar_show", methods={"GET"})
     */
    public function show(Grammar $grammar): Response
    {
        return $this->render('Admin/admin_grammar/show.html.twig', [
            'grammar' => $grammar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_grammar_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Grammar $grammar): Response
    {
        $form = $this->createForm(GrammarType::class, $grammar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_grammar_index');
        }

        return $this->render('Admin/admin_grammar/edit.html.twig', [
            'grammar' => $grammar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_grammar_delete", methods={"POST"})
     */
    public function delete(Request $request, Grammar $grammar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$grammar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($grammar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_grammar_index');
    }
}
