<?php

namespace App\Controller;

use App\Entity\Comentarios;
use App\Form\Comentarios1Type;
use App\Form\ComentariosType;
use App\Repository\ComentariosRepository;
use App\Repository\PublicacionesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/usuario/comentarios")
 */
class UsuarioComentariosController extends AbstractController
{
    /**
     * @Route("/", name="app_usuario_comentarios_index", methods={"GET"})
     */
    public function index(ComentariosRepository $comentariosRepository): Response
    {
        return $this->render('usuario_comentarios/index.html.twig', [
            'comentarios' => $comentariosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_usuario_comentarios_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ComentariosRepository $comentariosRepository, PublicacionesRepository $publicacionesRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $user = $userRepository->findOneBy(['id' => $user->getId()]);

        $comentario = new Comentarios();
        $form = $this->createForm(ComentariosType::class, $comentario);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Obtener la publicación correspondiente a partir del título
            $publicacion = $publicacionesRepository->findOneBy(['titulo' => $form->get('publicacion')->getData()->getTitulo()]);
            // Asignar el ID de la publicación a la propiedad publicacionesId del comentario
            $comentario->setPublicacionesId($publicacion->getId());
    
            // Asignar el userID y fecha de creación
            $comentario->setUserId($user->getId());
            $comentario->setFechaCreacion(new \DateTime());
    
            $comentariosRepository->add($comentario, true);
            return $this->redirectToRoute('app_usuario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuario_comentarios/new.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_usuario_comentarios_show", methods={"GET"})
     */
    public function show(Comentarios $comentario): Response
    {
        return $this->render('usuario_comentarios/show.html.twig', [
            'comentario' => $comentario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_usuario_comentarios_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Comentarios $comentario, ComentariosRepository $comentariosRepository): Response
    {
        $form = $this->createForm(ComentariosType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentariosRepository->add($comentario, true);

            return $this->redirectToRoute('app_usuario_comentarios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('usuario_comentarios/edit.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_usuario_comentarios_delete", methods={"POST"})
     */
    public function delete(Request $request, Comentarios $comentario, ComentariosRepository $comentariosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comentario->getId(), $request->request->get('_token'))) {
            $comentariosRepository->remove($comentario, true);
        }

        return $this->redirectToRoute('app_usuario_comentarios_index', [], Response::HTTP_SEE_OTHER);
    }
}
