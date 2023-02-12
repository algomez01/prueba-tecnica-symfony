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


class UserController extends AbstractController
{
    /* #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    } */

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserPasswordHasherInterface $encoderPassword, ManagerRegistry $doctrine): Response
    {
        $user = new User(User::ROLE_PACIENTE, "Paciente");
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $user->setPassword($endcoderPassword->hashPassword($user, $form->get("password")->getData()));

            if($this->isGranted(User::ROLE_ADMIN))
            {
                $user->setRoles([User::ROLE_MEDICO]);
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
        /* $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $user->setPassword($encoderPassword->hashPassword($user, $form['password']->getData())); //Encriptación
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            
        }

        return $this->renderForm('user/new.html.twig', [
            'formulario' => $form->createView(), //esto pertenece al back y sirve para conectarse al front 
        ]); */
    }

    /* #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    } */

    /* #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    } */

    /* #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    } */
}
