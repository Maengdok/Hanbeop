<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    class DocuController extends AbstractController {
        /**
         * @Route("/documentation", name="documentation")
         */
        public function docu() {
            return $this->render('docu/docu.html.twig');
        }
    }


?>