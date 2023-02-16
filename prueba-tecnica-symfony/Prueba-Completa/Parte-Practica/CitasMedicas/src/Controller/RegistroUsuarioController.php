<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistroUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroUsuarioController extends AbstractController
{
    /**
     * @Route("/registro/usuario", name="app_registro_usuario")
     */
    public function index(Request $request, UserPasswordHasherInterface $endcoderPassword, ManagerRegistry $doctrine): Response
    {
        $user = new User(User::ROLE_PACIENTE, "Paciente");
        $form = $this->createForm(RegistroUserType::class, $user);
    
        $form->handleRequest($request);
    
        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $user->setPassword($endcoderPassword->hashPassword($user, $form->get("password")->getData()));
    
            if($this->isGranted(User::ROLE_ADMIN))
            {
                $user->setRoles([User::ROLE_MEDICO]);
                $user->setTipo("Medico");
            }
            
    
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
    
             if($this->isGranted(User::ROLE_ADMIN))
             {
               return $this->redirectToRoute('app_admin');
             }
             else
             {
                return $this->redirectToRoute('app_login');
             }
        }
    
        return $this->render('registro_usuario\index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
    }