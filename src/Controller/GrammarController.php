<?php

    namespace App\Controller;

    use App\Entity\Category;
use App\Entity\Example;
use App\Entity\Level;
    use App\Entity\Exercice;
use App\Entity\Formulation;
use App\Entity\Grammar;
    use App\Entity\Letter;
use App\Entity\Meaning;
use App\Form\FavoriteTypeFormType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class GrammarController extends AbstractController {
        /**
         * @Route("/grammaire", name="grammar")
         */
        public function grammar() {
            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
            $levels = $this->getDoctrine()->getRepository(Level::class)->findAll();
            $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
            $letters = $this->getDoctrine()->getRepository(Letter::class)->findAll();

            return $this->render('grammar/grammar.html.twig', [
                'categories' => $categories,
                'levels' => $levels,
                'grammars' => $grammars,
                'letters' => $letters
            ]);
        }

        /**
         * @Route("/grammaire/{id}", name="show_grammar")
         */
        public function show($id, Request $request) {

            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
            $levels = $this->getDoctrine()->getRepository(Level::class)->findAll();
            $grammar = $this->getDoctrine()->getRepository(Grammar::class)->find($id);
            $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();
            $meaning = $this->getDoctrine()->getRepository(Meaning::class)->findAll();
            $examples = $this->getDoctrine()->getRepository(Example::class)->findAll();
            $formulations = $this->getDoctrine()->getRepository(Formulation::class)->findAll();

            return $this->render('grammar/show.html.twig', [
                'categories' => $categories,
                'levels' => $levels,
                'grammar' => $grammar,
                'exercices' => $exercices,
                'meaning' => $meaning,
                'examples' => $examples,
                'formulations' => $formulations,
            ]);
        }
    }

?>