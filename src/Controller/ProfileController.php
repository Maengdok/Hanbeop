<?php

    namespace App\Controller;


    use App\Entity\User;
    use App\Form\UserFormType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    class ProfileController extends AbstractController {
        /**
         * @Route("/profil", name="profile")
         */
        public function profile(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
            $user = $this->getUser();
            $formUser = $this->createForm(UserFormType::class, $user);
            
            $formUser->handleRequest($request);
            
            if ($formUser->isSubmitted() && $formUser->isValid()) {
                $originalPassword = $user->getPassword();
                $password = $formUser->get('password')->getData();
                
                if (!is_null($password)) {   
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $formUser->get('password')->getData()
                            )
                        );
                    }
                else {
                    $user->setPassword($originalPassword);
                }
                    
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash('profile_edit_success', "Le profil a bien été modifié");
                return $this->redirectToRoute('profile');
            }

            return $this->render('profile/profile.html.twig', [
                'user' => $user,
                'formUser' => $formUser->createView()
            ]);
        }

        /**
         * @Route("/profil/resilier", name="profile_cancel")
         */
        public function cancel_subscription(\Swift_Mailer $mailer) {
            $contactMessage = (new \Swift_Message('Résiliation abonnement'))
            ->setFrom($this->getUser()->getEmail())
            ->setTo('axel.pion@maengdok.fr')
            ->setBody('Demande de résiliation d\'abonnement de l\'email suivant:'.PHP_EOL.$this->getUser()->getEmail().'.');
            $mailer->send($contactMessage);
            
            $this->addFlash('cancel_success', 'Votre demande de résiliation a bien été envoyée et sera traitée dans les plus brefs delais.');

            return $this->redirectToRoute('profile');
        }

        /**
         * @Route("/profil/supprimer", name="profile_delete")
         */
        public function delete_account() {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            
            if ($answers = $this->getUser()->getUserAnswers()) {
    
                foreach ($answers as $answer) {
                    $delAnswers = $this->getUser()->removeUserAnswer($answer);
                    $em->remove($delAnswers);
                }
            }

            $this->get('security.token_storage')->setToken(null);
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('index');
        }
    }

?>