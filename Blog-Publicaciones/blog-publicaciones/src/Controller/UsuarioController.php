<?php

namespace App\Controller;

use App\Entity\Publicaciones;
use App\Form\Publicaciones2Type;
use App\Repository\ComentariosRepository;
use App\Repository\PublicacionesRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usuario")
 */
class UsuarioController extends AbstractController
{
    /**
     * @Route("/", name="app_usuario_index", methods={"GET"})
     */
    public function index(PublicacionesRepository $publicacionesRepository, UserRepository $userRepository): Response
    {
        $publicaciones = $publicacionesRepository->getPublicaciones();
        $user = $this->getUser();
        $trabajador = $userRepository->find($user->getId());
            
        return $this->render('usuario/index.html.twig', [
            'publicaciones' => $publicacionesRepository->findAll(),
            'publicaciones' => $publicaciones,
            'userTrabajador' => $trabajador,
        ]);
    }

    /**
     * @Route("/new", name="app_usuario_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PublicacionesRepository $publicacionesRepository): Response
    {
        $publicacione = new Publicaciones();
        $form = $this->createForm(Publicaciones2Type::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionesRepository->add($publicacione, true);

            return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuario/new.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_usuario_show", methods={"GET"})
     */
    public function show(Publicaciones $publicacione,ManagerRegistry $doctrine, PublicacionesRepository $publicacionesRepository, UserRepository $userRepository, ComentariosRepository $comentariosRepository): Response
    {
        $user = $this->getUser();
        $trabajador = $userRepository->findOneBy(['id' => $user->getId()]);
        $user = $userRepository->findOneBy(['id' => $user->getId()]);
        $trabajadorId = $publicacione->getTrabajadorId();
        $publicacione->setTrabajadorId($trabajador->getId());
        $publicacionesUser = $publicacionesRepository->getPublicacionesUser($trabajadorId);

        $comentarios = $comentariosRepository->getComentariosDePublicacion($publicacione->getId());

        return $this->render('usuario/show.html.twig', [
            'publicacione' => $publicacione,
            'publicacionesUser' => $publicacionesUser,
            'userTrabajador' => $trabajador,
            'user' => $user,
            'comentarios' => $comentarios
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_usuario_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository): Response
    {
        $form = $this->createForm(Publicaciones2Type::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionesRepository->add($publicacione, true);

            return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuario/edit.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_usuario_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicacione->getId(), $request->request->get('_token'))) {
            $publicacionesRepository->remove($publicacione, true);
        }

        return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
    }
}
