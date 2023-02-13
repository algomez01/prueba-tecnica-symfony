<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usuarios")
 */
class UsuariosController extends AbstractController
{
    /**
     * @Route("/", name="app_usuarios_index", methods={"GET"})
     */
   public function index(UserRepository $userRepository): Response
    {
        return $this->render('usuarios/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    } 

    /**
     * @Route("/new", name="app_usuarios_new", methods={"GET", "POST"})
     */
/*     public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            #return $this->redirectToRoute('app_usuarios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuarios/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    } */

    /**
     * @Route("/{id}", name="app_usuarios_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('usuarios/show.html.twig', [
            'user' => $user,
        ]);
    } 

    /**
     * @Route("/{id}/edit", name="app_usuarios_edit", methods={"GET", "POST"})
     */
/*     public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_usuarios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuarios/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    } */

    /**
     * @Route("/{id}", name="app_usuarios_delete", methods={"POST"})
     */
/*     public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_usuarios_index', [], Response::HTTP_SEE_OTHER);
    } */
}
