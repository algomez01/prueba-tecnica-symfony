<?php

namespace App\Controller;


use App\Controller\handleRequest ;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationUserController extends AbstractController
{
    #[Route('/registration/user', name: 'app_registration_user')]
    public function index(Request $request, UserPasswordHasherInterface $encoderPassword, ManagerRegistry $doctrine): Response
    {
        $user = new User(User::ROLE_SUPER, "Supervisor");
        $form = $this->createForm(RegistrateUserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $user->setPassword($encoderPassword->hashPassword($user,$form["password"]->getData()));

            if($this->isGranted(User::ROLE_SUPER))
            {
                $user->setRoles([User::ROLE_CAPA]);
                $user->serTipo("Capacitador");
                
            }

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            if ($this->isGranted(User::ROLE_SUPER))
            {
                return $this->redirectToRoute('app_supervisor_vista');
            }
            else{
                return $this->redirectToRoute('app_login');
            }
            
            
        }
        
        return $this->render('registration_user/index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
