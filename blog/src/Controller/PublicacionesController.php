<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Publicaciones;
use App\Form\PublicacionesType;
use App\Repository\PublicacionesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publicacioness")
 */
class PublicacionesController extends AbstractController
{
    /**
     * @Route("/", name="app_publicaciones_index", methods={"GET"})
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repCita = $doctrine->getRepository('App\Entity\Publicaciones');
        $repUser = $doctrine->getRepository('App\Entity\User');

        //recupero objUser
        $objUser = $repUser->findOneBy(["email"=>$user]);

        
        $arrayCitas = $repCita->getPublicacionUser($objUser->getId());
        return $this->render('publicaciones/index.html.twig', [
            'publicaciones' => $arrayCitas,
        ]);
    }

    /**
     * @Route("/new", name="app_publicaciones_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $publicacione = new Publicaciones();
        $repoPubli = $doctrine->getRepository('App\Entity\Publicaciones');
        $repoCategoria = $doctrine->getRepository('App\Entity\Categoria');
        $repoUsers = $doctrine->getRepository('App\Entity\User');
       
        $user = $request->getSession()->get("user");
        $objUser = $repoUsers->findOneBy(["email"=>$user]);
        
        $arrayTipoCategoria = $repoCategoria->findAll();

        $form = $this->createForm(PublicacionesType::class, $publicacione,['arrayTipocategoria'=>$arrayTipoCategoria]); 
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $publicacione->setUserid($objUser->getId());
            $publicacione->setCategoriaid($form["Categoria"]->getData()->getId());
            
            $repoPubli->add($publicacione, true);


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
    public function show(Publicaciones $publicacione): Response
    {
        return $this->render('publicaciones/show.html.twig', [
            'publicacione' => $publicacione,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_publicaciones_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository,ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $repoCategoria = $doctrine->getRepository("App\Entity\Categoria");
        $repoPubli = $doctrine->getRepository("App\Entity\Publicaciones");
        $repoUser = $doctrine->getRepository("App\Entity\User");
        $user = $request->getSession()->get('user');
        $objUser = $repoUser->findOneBy(["email"=>$user]);
        $arraycategoria= $repoCategoria->findAll();

        $form = $this->createForm(PublicacionesType::class, $publicacione,['arrayTipocategoria'=>$arraycategoria]); //se los envío al form para el choice
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacione->setCategoriaid($form["tipoCategoria"]->getData()->getId());
            $repoPubli->add($publicacione, true);
            $this->addFlash("notice","Publicación actualizada con éxito");
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
