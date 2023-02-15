<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistraUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
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
     * @Route("/registration/user", name="app_register_user_index")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoderPassword, ManagerRegistry $doctrine): Response
    {
        $user = new User(User::ROLE_EXTERNO, "Externo");//se inicai con el ussuario externo
        $form = $this->createForm(RegistraUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) //valida el formulario venga lleno
        {
            $user = $form->getData();
            $user->setPassword($encoderPassword->hashPassword($user, $form->get("password")->getData()));
            
            if ($this->isGranted(User::ROLE_ADMIN))
            {
                $user->setRoles([User::ROLE_EXTERNO]);
                $user->setTipoUsuario("Externo");
            }
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();

            if ($this->isGranted(User::ROLE_EXTERNO))
            {
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('register_user/index.html.twig', [
            'formRegister' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="app_register_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $encoderPassword): Response
    {
        $user = new User(User::ROLE_EXTERNO, "Externo");
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            //seteo de roles para registro desde el adminDashboard
            if($user->getTipoUsuario()=="Supervisor"){
                $role = User::ROLE_SUPERVISOR;
            }elseif($user->getTipoUsuario()=="Trabajador"){
                $role = User::ROLE_TRABAJADOR;
            }elseif($user->getTipoUsuario()=="Admin"){
                $role = User::ROLE_ADMIN;
            }

            $user->setRoles(array($role));
            $user->setPassword($encoderPassword->hashPassword($user, $form["password"]->getData()));
            $userRepository->add($user, true);
            return $this->redirectToRoute('app_login');
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

            return $this->redirectToRoute('app_register_user_index');
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
