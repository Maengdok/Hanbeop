<?php

namespace App\Controller;

use App\Entity\UserAnswer;
use App\Form\UserAnswerType;
use App\Repository\UserAnswerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user/answer")
 */
class AdminUserAnswerController extends AbstractController
{
    /**
     * @Route("/", name="admin_user_answer_index", methods={"GET"})
     */
    public function index(UserAnswerRepository $userAnswerRepository): Response
    {
        return $this->render('Admin/admin_user_answer/index.html.twig', [
            'user_answers' => $userAnswerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_user_answer_delete", methods={"POST"})
     */
    public function delete(Request $request, UserAnswer $userAnswer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userAnswer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userAnswer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_user_answer_index');
    }
}
