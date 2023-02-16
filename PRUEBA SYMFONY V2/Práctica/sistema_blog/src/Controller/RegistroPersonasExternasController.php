<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PersonasExternasType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistroPersonasExternasController extends AbstractController
{
    /**
     * @Route("/registroExternos", name="app_registro_externos")
     */
    public function index(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(PersonasExternasType::class, $user); 
        $form->handleRequest($request);
        $role = User::ROLE_EXTERNOS; //inicializa con el rol de las personas externas

        if ($form->isSubmitted() && $form->isValid()) {
            //encriptar la contraseña
            $user = $form->getData();
            $user->setPassword($encoder->hashPassword($user,$form["password"]->getData()));

            $user->setRoles([$role]);
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('registro/registroPersonasExternas.html.twig', [
            'formulario' => $form->createView(), //esto pertenece al back y sirve para conectarse al front 
        ]);
    }
}
