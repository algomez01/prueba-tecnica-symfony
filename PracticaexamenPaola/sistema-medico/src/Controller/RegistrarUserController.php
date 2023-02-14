<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrarUserController extends AbstractController
{
    /**
     * @Route("/registrar/user", name="app_registrar_user")
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $role = User::ROLE_PACIENTE; //inicializa con el rol de paciente

        if ($form->isSubmitted() && $form->isValid()) {
            //seteo de rol de acuerdo a lo seleccionado en el choice
            if($user->getTipoUsuario() == "Doctor"){
                $role = User::ROLE_DOCTOR;
            }elseif($user->getTipoUsuario() == "Cajero"){
                $role = User::ROLE_CAJERO;
            }elseif($user->getTipoUsuario() == "Admin"){
                $role = User::ROLE_ADMIN;
            }

            $user->setRoles(array($role));

            //encripta password
            $user->setPassword($encoder->hashPassword($user,$form["password"]->getData()));

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('registrar_user/_form.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
