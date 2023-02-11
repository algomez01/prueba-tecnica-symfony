<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterUserController extends AbstractController
{
    /**
     * @Route("/registration/user", name="app_registration_user")
     */
    public function index(Request $request,UserPasswordHasherInterface $encoderPassword, ManagerRegistry $doctrine ): Response
    {
       //$user= new User(User::ROLE_ADMINISTRADOR,"ADMINISTRADOR");
       $user= new User(User::ROLE_MEDICO,"MEDICO");
       $form = $this->createForm(RegistrationType::class,$user);

       $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $user= $form->getData();
        $user-> setPassword($encoderPassword->hashPassword($user, $form["password"]->getData()));
        if($this->isGranted(User::ROLE_ADMINISTRADOR)){
            $user->setRoles([User::ROLE_MEDICO]);
            $user->setRoles([User::ROLE_PACIENTE]);
            

            
  
           
        }
        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();
        if($this->isGranted(User::ROLE_MEDICO)){
        return $this->redirectToRoute('app_cita');
        }
        elseif($this->isGranted(User::ROLE_PACIENTE)){
            return $this->redirectToRoute('app_paciente_dash_board');
            }
            elseif($this->isGranted(User::ROLE_ADMINISTRADOR)){
                return $this->redirectToRoute('app_administrador');
                }    
        else{
            return $this->redirectToRoute('app_login'); 
        }
    }
        return $this->render('register_user/index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }

}



