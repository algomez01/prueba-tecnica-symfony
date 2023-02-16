<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="app_registro")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $rol = User::ROLE_PACIENTE;

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($encoder->hashPassword($user, $form['password']->getData()));

            if($user->getTipoUsuario() == "Medico"){
                $rol = User::ROLE_MEDICO;
            }elseif($user->getTipoUsuario() == "Admin"){
                $rol = User::ROLE_ADMIN;
            }elseif($user->getTipoUsuario() == "Cajero"){
                $rol = User::ROLE_CAJERO;
            }

                $user->setRoles([$rol]);
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();


            return $this->redirectToRoute('app_login');
        }
        return $this->render('registro/index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
