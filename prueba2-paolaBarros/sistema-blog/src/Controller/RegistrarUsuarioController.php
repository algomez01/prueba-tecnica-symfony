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

class RegistrarUsuarioController extends AbstractController
{
    /**
     * @Route("/registrar/usuario", name="app_registrar_usuario")
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder): Response
    
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $role = User::ROLE_SUPERVISOR; 

        if ($form->isSubmitted() && $form->isValid()) {
            //seteo de rol de acuerdo a lo seleccionado en el choice
           if($user->getTipoUsuario() == "Supervisor"){
                $role = User::ROLE_SUPERVISOR;
            }elseif($user->getTipoUsuario() == "Empleado"){
                $role = User::ROLE_EMPLEADO;
            }
            
            elseif($user->getTipoUsuario() == "Administrador"){
                $role = User::ROLE_ADMINISTRADOR;
            }
            $user->setRoles(array($role));

            //encripta password
            $user->setPassword($encoder->hashPassword($user,$form["password"]->getData()));

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('registrar_usuario/_form.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
