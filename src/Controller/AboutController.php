<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;

    class AboutController extends AbstractController {
        /**
         * @Route("/aboutUs", name="about")
         */
        public function about() {
            return $this->render("about/about.html.twig");
        }
    }

?>