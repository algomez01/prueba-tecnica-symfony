<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Entity\Publicaciones;
use App\Form\ComentarioType;
use App\Repository\ComentarioRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComentarioController extends AbstractController
{
    /**
     * @Route("/publicacion", name="app_publicaciones_index1", methods={"GET"})
     */
    public function index1(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repCita = $doctrine->getRepository('App\Entity\Publicaciones');
        $repUser = $doctrine->getRepository('App\Entity\User');

        //recupero objUser
        $objUser = $repUser->findOneBy(["email"=>$user]);

        //creamos nuevo método en repositorio para recuperar el nombre del médico en vez del id
        $arrayCitas = $repCita->getPublicacionUser($objUser->getId());
        return $this->render('comentario/publicacion.html.twig', [
            'publicaciones' => $arrayCitas,
        ]);
    }
    
    

    

    /**
     * @Route("/{id}/edit", name="app_comentario_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Comentario $comentario, ComentarioRepository $comentarioRepository): Response
    {
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentarioRepository->add($comentario, true);

            return $this->redirectToRoute('app_comentario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comentario/edit.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_comentario_delete", methods={"POST"})
     */
    public function delete(Request $request, Comentario $comentario, ComentarioRepository $comentarioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comentario->getId(), $request->request->get('_token'))) {
            $comentarioRepository->remove($comentario, true);
        }

        return $this->redirectToRoute('app_comentario_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/{id}/new/fsdf", name="app_comentario_new", methods={"GET", "POST"})
     */
    public function new(Publicaciones $publicaciones, Request $request, ManagerRegistry $doctrine): Response
    {
        $comentario = new Comentario();
        $repoComentario = $doctrine->getRepository('App\Entity\Comentario');
        $repoPublicacion = $doctrine->getRepository('App\Entity\Publicaciones');
        $repoUsers = $doctrine->getRepository('App\Entity\User');
       
        $user = $request->getSession()->get("user");
        $objUser = $repoUsers->findOneBy(["email"=>$user]);
        
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentario->setUserid($objUser->getId());
            $comentario->setPublicacionid($publicaciones->getId());
            $repoComentario->add($comentario, true);
        

            return $this->redirectToRoute('app_comentario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comentario/new.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }
    
    /**
     * @Route("/comentario", name="app_comentario_index", methods={"GET"})
     */
    public function index(ComentarioRepository $comentarioRepository): Response
    {

        return $this->render('comentario/index.html.twig', [
            'comentarios' => $comentarioRepository->findAll(),
        ]);
    }

}
