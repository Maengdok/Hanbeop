<?php

namespace App\Controller;

use App\Entity\Exercice;
use App\Entity\Grammar;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('Admin/index.html.twig', [
            'grammars' => $grammars,
            'exercices' => $exercices,
            'users' => $users,
        ]);
    }
}
