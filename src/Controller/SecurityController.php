<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    private UtilisateurRepository $utilisateurRepository;

    /**
     * @param UtilisateurRepository $utilisateurRepository
     */
    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
    }


    #[Route('/in', name: 'app_security_inscription', methods: ['GET','POST'],priority: 1)]
    public function inscription(Request $request, UserPasswordHasherInterface $encoder){
        $user = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user->setCreatedAt(new \DateTime())
                ->setActif(1)
                ->setRoles(["ROLE_USER"]);
            $this->utilisateurRepository->save($user,true);
            return $this->redirectToRoute('app_security_login');
        }



        return $this->render('security/inscription.html.twig',[
        'form' => $form->createView()
    ]);
    }

   /* #[Route('/connexion', name: 'app_security_login')]
    public function login(){
            return $this->render('security/login.html.twig');
    }

    #[Route('/deconnexion', name: 'app_security_logout')]
    public function logout(){}*/

   #[Route(path: '/login', name: 'app_login')]
   public function login(AuthenticationUtils $authenticationUtils): Response
   {
       // if ($this->getUser()) {
       //     return $this->redirectToRoute('target_path');
       // }

       // get the login error if there is one
       $error = $authenticationUtils->getLastAuthenticationError();
       // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();

       return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
   }

   #[Route(path: '/logout', name: 'app_logout')]
   public function logout(): void
   {
       throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
   }
}
