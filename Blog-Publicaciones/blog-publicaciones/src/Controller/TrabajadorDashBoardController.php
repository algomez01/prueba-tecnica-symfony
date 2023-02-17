<?php

namespace App\Controller;

use App\Entity\Comentarios;
use App\Entity\Publicaciones;
use App\Entity\User;
use App\Form\CategoriasType;
use App\Form\ComentariosType;
use App\Form\PublicacionesType;
use App\Repository\CategoriasRepository;
use App\Repository\ComentariosRepository;
use App\Repository\PublicacionesRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trabajador/dash/board")
 */
class TrabajadorDashBoardController extends AbstractController
{
    /**
     * @Route("/", name="app_trabajador_dash_board_index", methods={"GET"})
     */
    public function index(PublicacionesRepository $publicacionesRepository, UserRepository $userRepository): Response
    {
        $publicaciones = $publicacionesRepository->getPublicacionesUser($this->getUser()->getId());
        $user = $this->getUser();
        $trabajador = $userRepository->find($user->getId());

    
        return $this->render('trabajador_dash_board/index.html.twig', [
            'publicaciones' => $publicaciones,
            'userTrabajador' => $trabajador,
        ]);
    }
    

    /**
     * @Route("/new", name="app_trabajador_dash_board_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PublicacionesRepository $publicacionesRepository, UserRepository $userRepository, UserPasswordHasherInterface $encoder, ManagerRegistry $doctrine, CategoriasRepository $categoriasRepository): Response
    {
        $publicacione = new Publicaciones();
    
        $user = $this->getUser();
        $trabajador = $userRepository->findOneBy(['id' => $user->getId()]);
        
        $arrayCategorias = $categoriasRepository->findAll();
    
        // crea el formulario, pasando las opciones del desplegable
        $form = $this->createForm(PublicacionesType::class, $publicacione, [
            'arrayCategorias' => $arrayCategorias
        ]);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $publicacione->setCategoriaId($form["categorias"]->getData()->getId());
            $publicacione->setTrabajadorId($trabajador->getId());
            $publicacione->setfechacreacion(new \DateTime());
    
            $publicacionesRepository->add($publicacione, true);
    
            $this->addFlash("notice","Publicación ingresada con éxito");
    
            return $this->redirectToRoute('app_trabajador_dash_board_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('trabajador_dash_board/new.html.twig', [
            'form' => $form,
            'userTrabajador' => $trabajador
        ]);
    }
    
    
    

    /**
     * @Route("/{id}", name="app_trabajador_dash_board_show", methods={"GET"})
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

        return $this->render('trabajador_dash_board/show.html.twig', [
        'publicacione' => $publicacione,
        'publicacionesUser' => $publicacionesUser,
        'userTrabajador' => $trabajador,
        'user' => $user,
        'comentarios' => $comentarios
        ]);
    }
    


    /**
     * @Route("/{id}/edit", name="app_trabajador_dash_board_edit", methods={"GET", "POST"})
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

            return $this->redirectToRoute('app_trabajador_dash_board_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trabajador_dash_board/edit.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_trabajador_dash_board_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicacione->getId(), $request->request->get('_token'))) {
            $publicacionesRepository->remove($publicacione, true);
        }

        return $this->redirectToRoute('app_trabajador_dash_board_index', [], Response::HTTP_SEE_OTHER);
    }
}
