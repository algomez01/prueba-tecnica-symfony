<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrateUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationUserController extends AbstractController
{
    /**
     * @Route("/registration/user", name="app_registration_user")
     */
    public function index(Request $request, UserPasswordHasherInterface $endcoderPassword, ManagerRegistry $doctrine): Response
    {
        $user = new User(User::ROLE_ESTUDIANTE, "Estudiante");
        $form = $this->createForm(RegistrateUserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $user->setPassword($endcoderPassword->hashPassword($user, $form->get("password")->getData()));

            if($this->isGranted(User::ROLE_ADMIN))
            {
                $user->setRoles([User::ROLE_CAPACITADOR]);
                $user->setTipo("Capacitador");
            }

            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

             if($this->isGranted(User::ROLE_ADMIN))
             {
               return $this->redirectToRoute('app_admin_dash_board');
             }
             else
             {
                return $this->redirectToRoute('app_login');
             }
        }

        return $this->render('registration_user/index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
