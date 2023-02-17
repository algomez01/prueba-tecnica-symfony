<?php

namespace App\Controller;

use App\Entity\Publicaciones;
use App\Form\PublicacionesType;
use App\Repository\CategoriaRepository;
use App\Repository\ComentariosRepository;
use App\Repository\PublicacionesRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publicaciones")
 */
class PublicacionesController extends AbstractController
{
    /**
     * @Route("/", name="app_publicaciones_index", methods={"GET"})
     */
    public function index(PublicacionesRepository $publicacionesRepository): Response
    {
        return $this->render('publicaciones/index.html.twig', [
            'publicaciones' => $publicacionesRepository->findAll(),
        ]);
    }  

    //Controlador para mostrar la página de bienvenida y cuadro de opciones
    /**
     * @Route("/", name="app_publicaciones_bienvenida", methods={"GET"})
     */
   /*  public function bienvenida(PublicacionesRepository $publicacionesRepository, ManagerRegistry $doctrine): Response
    {

        //Se genera el método para mostrar la página de bienvenida
        return $this->render('publicaciones/bienvenidaAdmin.html.twig', [
            'publicaciones' => $publicacionesRepository->findAll(),
        ]);
    } */

    


    /**
     * @Route("/new", name="app_publicaciones_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PublicacionesRepository $publicacionesRepository): Response
    {

        $publicacione = new Publicaciones();
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionesRepository->add($publicacione, true);

            return $this->redirectToRoute('app_publicaciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publicaciones/new.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_publicaciones_show", methods={"GET"})
     */
    public function show(Publicaciones $publicacione, ManagerRegistry $doctrine, PublicacionesRepository $publicacionesRepository, UserRepository $userRepository, ComentariosRepository $comentariosRepository): Response
    {
        $user = $this->getUser();
        $trabajador = $userRepository->findOneBy(['id' => $user->getId()]);
        $user = $userRepository->findOneBy(['id' => $user->getId()]);
       // $trabajadorId = $publicacione->getTrabajadorId();
        //$publicacione->setTrabajadorId($trabajador->getId());
           // $publicacionesUser = $publicacionesRepository->getPublicacionesUser($trabajadorId);
        $comentarios = $comentariosRepository->getComentariosPublicacion($publicacione->getId());

        return $this->render('publicaciones/show.html.twig', [
            'publicacione' => $publicacione,
            'trabajador' => $trabajador,
            'user' => $user,
            'comentarios' => $comentarios,
            
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_publicaciones_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository, ManagerRegistry $doctrine, CategoriaRepository $category): Response
    {
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $repoCateogiras = $doctrine->getRepository('App\Entity\Categoria');
        $arrayCategorias = $repoCateogiras->findAll();
        $form = $this->createForm(PublicacionesType::class, $publicacione, array('arrayCategorias' => $arrayCategorias));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionesRepository->add($publicacione, true);

            $this->addFlash('success', 'Publicación editada con éxito');
            return $this->redirectToRoute('app_publicaciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publicaciones/edit.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_publicaciones_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicacione->getId(), $request->request->get('_token'))) {
            $publicacionesRepository->remove($publicacione, true);
        }

        return $this->redirectToRoute('app_publicaciones_index', [], Response::HTTP_SEE_OTHER);
    }
}
