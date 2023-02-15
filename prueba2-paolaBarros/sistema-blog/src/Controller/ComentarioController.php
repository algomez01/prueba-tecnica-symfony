<?php

namespace App\Controller;

use App\Entity\Comentario;
use App\Entity\Publicacion;
use App\Form\ComentarioType;
use App\Repository\ComentarioRepository;
use App\Repository\PublicacionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comentario")
 */
class ComentarioController extends AbstractController
{
    /**
     * @Route("/", name="app_comentario_index", methods={"GET"})
     */
    public function index(ComentarioRepository $comentarioRepository): Response
    {
        return $this->render('comentario/index.html.twig', [
            'comentarios' => $comentarioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_comentario_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ComentarioRepository $comentarioRepository): Response
    {
        $comentario = new Comentario();
        $form = $this->createForm(ComentarioType::class, $comentario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comentarioRepository->add($comentario, true);

            return $this->redirectToRoute('app_comentario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comentario/new.html.twig', [
            'comentario' => $comentario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_comentario_show", methods={"GET"})
     */
    public function show(Comentario $comentario): Response
    {
        return $this->render('comentario/show.html.twig', [
            'comentario' => $comentario,
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
     * @Route("/comentariolist", name="app_comentario1_index", methods={"GET"})
     */
   
     public function edit1(Request $request, Publicacion $publicacion, PublicacionRepository $publicacionRepository,ManagerRegistry $doctrine): Response
     {
         
         $repCategoria = $doctrine->getRepository('App\Entity\Categoria');
         $arrayCategoria = $repCategoria->findAll();
         $form = $this->createForm(PublicacionType::class, $publicacion,['arrayCategoria'=>$arrayCategoria]); 
         $form->handleRequest($request);
        
 
         if ($form->isSubmitted() && $form->isValid()) {
             //cuando se actualiza se refresca su hora de creacion
             //fecha del sistema
             $publicacion->setCategoriaId($form["categoria"]->getData()->getId());
             $publicacionRepository->add($publicacion, true);
 
             $this->addFlash("notice","Publicacion actualizada ");
             return $this->redirectToRoute('app_comentario_index', [], Response::HTTP_SEE_OTHER);
         }
 
         return $this->renderForm('comentario/publicacion.html.twig', [
             'publicacion' => $publicacion,
             'form' => $form,
         ]);
     }
     
        /**
         * @Route("/publicacion", name="app_publicaciones_index1", methods={"GET"})
         */
        public function index1(Request $request, ManagerRegistry $doctrine): Response
        {
            $user = $request->getSession()->get("user");
    
            //recupero repositorios
            $repCita = $doctrine->getRepository('App\Entity\Publicacion');
            $repUser = $doctrine->getRepository('App\Entity\User');
    
            //recupero objUser
            $objUser = $repUser->findOneBy(["email"=>$user]);
    
            //creamos nuevo método en repositorio para recuperar el nombre del médico en vez del id
            $arrayCitas = $repCita->getPublicacionUser($objUser->getId());
            return $this->render('comentario/publicacion.html.twig', [
                'publicaciones' => $arrayCitas,
            ]);
        }
}
