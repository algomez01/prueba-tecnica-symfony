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
 * @Route("/admin/dash/board")
 */
class AdminDashBoardController extends AbstractController
{
    /**
     * @Route(name="app_admin_dash_board_primeravista")
     */
    public function primeravista(UserRepository $userRepository): Response
    {
        return $this->render('admin_dash_board/Primeravista.html copy.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/", name="app_admin_dash_board_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin_dash_board/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="app_admin_dash_board_new", methods={"GET", "POST"})
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

        return $this->renderForm('admin_dash_board/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_dash_board_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin_dash_board/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_dash_board_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_admin_dash_board_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_dash_board/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_dash_board_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_admin_dash_board_index', [], Response::HTTP_SEE_OTHER);
    }

   
}
