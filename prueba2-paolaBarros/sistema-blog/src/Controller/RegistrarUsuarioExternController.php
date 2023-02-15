<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registrar/usuario/extern")
 */
class RegistrarUsuarioExternController extends AbstractController
{
    /**
     * @Route("/", name="app_registrar_usuario_extern_index")
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder): Response
    
    {
        $user = new User();
        $form = $this->createForm(UserEType::class, $user);
        $form->handleRequest($request);
        $role = User::ROLE_PERSONAEXTERNA; 
        if ($form->isSubmitted() && $form->isValid()) {
            //seteo de rol de acuerdo a lo seleccionado en el choice
            if($user->getTipoUsuario() == "PersonaExterna"){
                $role = User::ROLE_PERSONAEXTERNA;
            
            }
            $user->setRoles(array($role));

            //encripta password
            $user->setPassword($encoder->hashPassword($user,$form["password"]->getData()));

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('registrar_usuario_extern/_form.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
