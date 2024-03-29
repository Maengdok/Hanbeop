<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/question")
 */
class AdminQuestionController extends AbstractController
{
    /**
     * @Route("/", name="admin_question_index", methods={"GET"})
     */
    public function index(QuestionRepository $questionRepository): Response
    {
        return $this->render('Admin/admin_question/index.html.twig', [
            'questions' => $questionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_question_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('admin_question_index');
        }

        return $this->render('Admin/admin_question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_question_show", methods={"GET"})
     */
    public function show(Question $question): Response
    {
        return $this->render('Admin/admin_question/show.html.twig', [
            'question' => $question,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_question_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_question_index');
        }

        return $this->render('Admin/admin_question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_question_delete", methods={"POST"})
     */
    public function delete(Request $request, Question $question): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_question_index');
    }
}
