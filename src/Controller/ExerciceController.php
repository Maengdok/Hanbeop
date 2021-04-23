<?php

    namespace App\Controller;

    use App\Entity\Answer;
    use App\Entity\Exercice;
    use App\Entity\Category;
    use App\Entity\Grammar;
    use App\Entity\Letter;
    use App\Entity\Question;
    use App\Entity\UserAnswer;
    use App\Form\UserAnswerType;
use DOMDocument;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class ExerciceController extends AbstractController {
        /**
         * @Route("/exercices", name="exercices")
         */
        public function exercices() {
            $exercices = $this->getDoctrine()->getRepository(Exercice::class)->findAll();
            $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
            $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
            $letters = $this->getDoctrine()->getRepository(Letter::class)->findAll();

            return $this->render('exercices/exercices.html.twig', [
                'exercices' => $exercices,
                'categories' => $categories,
                'grammars' => $grammars,
                'letters' => $letters,
            ]);
        }

        /**
         * @Route("/exercices/{id}", name="show_exercice")
         */
        public function exercice($id, Request $request) {
            $exercice = $this->getDoctrine()->getRepository(Exercice::class)->find($id);
            $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
            $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();
            $answers = $this->getDoctrine()->getRepository(Answer::class)->findAll();
            $userAnswers = $this->getDoctrine()->getRepository(UserAnswer::class)->findAll();
            
            return $this->render('exercices/show.html.twig', [
                'id' => $id,
                'exercice' => $exercice,
                'grammars' => $grammars,
                'questions' => $questions,
                'answers' => $answers,
                'userAnswers' => $userAnswers,
            ]);
        }
        
        /**
         * @Route("/exercices/{id}/question/{question_id}/answer/{answer_id}", name="add_userAnswer")
         */
        public function addUserAnswer($id, $question_id, $answer_id) {
            $questions = $this->getDoctrine()->getRepository(Question::class)->find($question_id);
            $answers = $this->getDoctrine()->getRepository(Answer::class)->find($answer_id);

            $userAnswer = new UserAnswer;
            $userAnswer->setUser($this->getUser());
            $userAnswer->setQuestion($questions);
            $userAnswer->setAnswer($answers);

            $form = $this->createForm(UserAnswerType::class, $userAnswer);

            $em = $this->getDoctrine()->getManager();
            $em->persist($userAnswer);
            $em->flush();
            
            return $this->redirectToRoute('show_exercice', [
                'id' => $id
            ]);
        }

        /**
         * @Route("/exercices/{id}/answer", name="show_answer")
         */
        public function showAnswers($id) {
            $exercice = $this->getDoctrine()->getRepository(Exercice::class)->find($id);
            $grammars = $this->getDoctrine()->getRepository(Grammar::class)->findAll();
            $questions = $this->getDoctrine()->getRepository(Question::class)->findAll();
            $answers = $this->getDoctrine()->getRepository(Answer::class)->findAll();
            $userAnswers = $this->getDoctrine()->getRepository(UserAnswer::class)->findAll();

            return $this->render('exercices/answers.html.twig', [
                'id' => $id,
                'exercice' => $exercice,
                'grammars' => $grammars,
                'questions' => $questions,
                'answers' => $answers,
                'userAnswers' => $userAnswers,
            ]);
        }
    }

?>