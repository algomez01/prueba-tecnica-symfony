<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
     /**
     * @Route("/", name="app_registro_index", methods={"GET"})
     */
    public function ver(UserRepository $userRepository): Response
    {
        return $this->render('registro/ver.html.twig', [
            'verUsuario' => $userRepository->findAll(),
        ]);
    } 
    
    /**
     * @Route("/registro", name="app_registro_new")
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $role = User::ROLE_EXTERNOS; //inicializa con el rol de las personas externas

        if ($form->isSubmitted() && $form->isValid()) {
            //encriptar la contraseña
            $user = $form->getData();
            $user->setPassword($encoder->hashPassword($user,$form["password"]->getData()));
            //seteo de rol de acuerdo a lo seleccionado en el choice
            if($user->getTipoUsuario() == "Trabajadores"){
                $role = User::ROLE_TRABAJADORES;
            }elseif($user->getTipoUsuario() == "Supervisores"){
                $role = User::ROLE_SUPERVISORES;
            }elseif($user->getTipoUsuario() == "Admin"){
                $role = User::ROLE_ADMIN;
            }

            $user->setRoles([$role]);
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('registro/index.html.twig', [
            'formulario' => $form->createView(), //esto pertenece al back y sirve para conectarse al front 
        ]);
    }


}
