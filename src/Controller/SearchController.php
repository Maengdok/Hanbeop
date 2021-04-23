<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Exercice;
use App\Entity\Grammar;
use App\Entity\Letter;
use App\Entity\Level;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/recherche/grammaire/par-categorie/{id}", name="search_gCategory")
     */
    public function grammarCategory($id): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $levels = $this->getDoctrine()->getRepository(Level::class)->findAll();

        return $this->render('search/per_g_category.html.twig', [
            'category' => $category,
            'grammars' => $grammars,
            'levels' => $levels,
        ]);
    }

    /**
     * @Route("/recherche/grammaire/par-niveau/{id}", name="search_gLevel")
     */
    public function grammarLevel($id): Response
    {
        $level = $this->getDoctrine()->getRepository(Level::class)->find($id);
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();


        return $this->render('search/per_g_level.html.twig', [
            'level' => $level,
            'grammars' => $grammars,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/recherche/grammaire/par-letter/{id}", name="search_gLetter")
     */
    public function grammarLeteer($id): Response
    {
        $letter = $this->getDoctrine()->getRepository(Letter::class)->find($id);
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();


        return $this->render('search/per_g_letter.html.twig', [
            'letter' => $letter,
            'grammars' => $grammars,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/recherche/exercice/par-access/gratuit", name="search_eFree")
     */
    public function exerciceFree(): Response
    {
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();

        return $this->render('search/per_e_free.html.twig', [
            'grammars' => $grammars,
            'exercices' => $exercices,
        ]);
    }

    /**
     * @Route("/recherche/exercice/par-access/premium", name="search_ePremium")
     */
    public function exercicePremium(): Response
    {
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();

        return $this->render('search/per_e_premium.html.twig', [
            'grammars' => $grammars,
            'exercices' => $exercices,
        ]);
    }

    /**
     * @Route("/recherche/exercice/par-difficulte/facile", name="search_eEasy")
     */
    public function exerciceEasy(): Response
    {
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();

        return $this->render('search/per_e_easy.html.twig', [
            'grammars' => $grammars,
            'exercices' => $exercices,
        ]);
    }

    /**
     * @Route("/recherche/exercice/par-difficulte/moyen", name="search_eMedium")
     */
    public function exerciceMedium(): Response
    {
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();

        return $this->render('search/per_e_medium.html.twig', [
            'grammars' => $grammars,
            'exercices' => $exercices,
        ]);
    }

    /**
     * @Route("/recherche/exercice/par-difficulte/difficile", name="search_eHard")
     */
    public function exerciceHard(): Response
    {
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();

        return $this->render('search/per_e_hard.html.twig', [
            'grammars' => $grammars,
            'exercices' => $exercices,
        ]);
    }

    /**
     * @Route("/recherche/exercice/par-lettre/{id}", name="search_eLetter")
     */
    public function exerciceLetter($id): Response
    {
        $letter = $this->getDoctrine()->getRepository(Letter::class)->find($id);
        $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
        $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();

        return $this->render('search/per_e_letter.html.twig', [
            'letter' => $letter,
            'grammars' => $grammars,
            'exercices' => $exercices,
        ]);
    }
}
