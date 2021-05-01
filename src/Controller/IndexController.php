<?php

    namespace App\Controller;

use App\Entity\Category;
use App\Entity\Exercice;
use App\Entity\Grammar;
use App\Entity\Level;
use App\Entity\Meaning;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class IndexController extends AbstractController {
        /**
         * @Route("/", name="index")
         */
        public function index() {
            $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
            $levels = $this->getDoctrine()->getRepository(Level::class)->findAll();
            $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();
            $meanings = $this->getDoctrine()->getRepository(Meaning::class)->findAll();
            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

            return $this->render('index/index.html.twig', [
                'grammars' => $grammars,
                'levels' => $levels,
                'exercices' => $exercices,
                'meanings' => $meanings,
                'categories' => $categories,
            ]);
        }
    }

?>