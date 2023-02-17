<?php

namespace App\Controller;

use App\Entity\Publicaciones;
use App\Entity\Cate;
use App\Form\PublicacionesType;
use App\Repository\CategoriasRepository;
use App\Repository\ComentariosRepository;
use App\Repository\PublicacionesRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/publicaciones")
 */
class AdminPublicacionesController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_publicaciones_index", methods={"GET"})
     */
    public function index(PublicacionesRepository $publicacionesRepository, UserRepository $userRepository): Response
    {
        $publicaciones = $publicacionesRepository->getPublicaciones();
        $user = $this->getUser();
        $trabajador = $userRepository->find($user->getId());
            
        return $this->render('admin_publicaciones/index.html.twig', [
            'publicaciones' => $publicaciones,
            'userTrabajador' => $trabajador,
        ]);
    }
    

    /**
     * @Route("/new", name="app_admin_publicaciones_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PublicacionesRepository $publicacionesRepository): Response
    {
        $publicacione = new Publicaciones();
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionesRepository->add($publicacione, true);

            return $this->redirectToRoute('app_admin_publicaciones_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_publicaciones/new.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_publicaciones_show", methods={"GET"})
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
        return $this->render('admin_publicaciones/show.html.twig', [
            'publicacione' => $publicacione,
            'publicacionesUser' => $publicacionesUser,
            'userTrabajador' => $trabajador,
            'user' => $user,
            'comentarios' => $comentarios
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_publicaciones_edit", methods={"GET", "POST"})
     */
     public function edit(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository,ManagerRegistry $doctrine): Response
     {
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $repCategorias = $doctrine->getRepository('App\Entity\Categorias');
        $arrayCategorias = $repCategorias->findAll();
        $form = $this->createForm(PublicacionesType::class, $publicacione,['arrayCategorias'=>$arrayCategorias]); 

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacione->setCategoriaId($form["categorias"]->getData()->getId());
            $publicacionesRepository->add($publicacione, true);

            $this->addFlash("notice","Publicacion actualizada ");


          return $this->redirectToRoute('app_admin_publicaciones_index');
     }

          return $this->render('admin_publicaciones/edit.html.twig', [
           'publicacione' => $publicacione,
           'form' => $form->createView(),
         ]);
     }


    /**
     * @Route("/{id}", name="app_admin_publicaciones_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicacione->getId(), $request->request->get('_token'))) {
            $publicacionesRepository->remove($publicacione, true);
        }

        return $this->redirectToRoute('app_admin_publicaciones_index', [], Response::HTTP_SEE_OTHER);
    }
}
