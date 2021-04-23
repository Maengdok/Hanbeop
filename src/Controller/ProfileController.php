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
    }

?>