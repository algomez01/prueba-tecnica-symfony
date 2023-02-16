<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/register/user")
 */
class RegisterUserController extends AbstractController
{
    /**
     * @Route("/", name="app_register_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('register_user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_register_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $role = User::ROLE_USUARIO; //inicializa con el rol de usuario

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setFeCreacion(new \DateTime()); //fecha del sistema 

            //seteo de rol de acuerdo a lo seleccionado en el choice
            if($user->getTipoUsuario() == "Trabajador"){
                $role = User::ROLE_TRABAJADOR;
            }elseif($user->getTipoUsuario() == "Supervisor"){
                $role = User::ROLE_SUPERVISOR;
            }elseif($user->getTipoUsuario() == "Admin"){
                $role = User::ROLE_ADMIN;
            }

            $user->setRoles(array($role));

            //encripta password
            $user->setPassword($encoder->hashPassword($user,$form["password"]->getData()));

            $userRepository->add($user, true);

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('register_user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    

    /**
     * @Route("/{id}", name="app_register_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('register_user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_register_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_register_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('register_user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_register_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_register_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
