<?php

namespace App\Controller;

use App\Entity\Publicacion;
use App\Form\PublicacionType;
use App\Repository\PublicacionRepository;
use Doctrine\Persistence\ManagerRegistry;;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trabajador")
 */
class TrabajadorController extends AbstractController
{
    /**
     * @Route("/trabajador", name="app_trabajador_index", methods={"GET"})
     */
   
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repCita = $doctrine->getRepository('App\Entity\Publicacion');
        $repUser = $doctrine->getRepository('App\Entity\User');

        //recupero objUser
        $objUser = $repUser->findOneBy(["email"=>$user]);

        //creamos nuevo método en repositorio para recuperar el nombre del médico en vez del id
        $arrayCitas = $repCita->getPublicacionUser($objUser->getId());

        return $this->render('trabajador/index.html.twig', [
            'publicacions' => $arrayCitas, //consulta solo citas del usuario logueado
        ]);
    }
        

    /**
     * @Route("/new", name="app_trabajador_new", methods={"GET", "POST"})
     */
   
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $publicacion = new Publicacion();
        $form = $this->createForm(PublicacionType::class, $publicacion);
        $form->handleRequest($request);

        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repPublicacion = $doctrine->getRepository('App\Entity\Publicacion');
        $repUser = $doctrine->getRepository('App\Entity\User');
        $repCategoria = $doctrine->getRepository('App\Entity\Categoria');
        $arrayCategoria = $repCategoria->findAll();
        //recupero objUser
        $objUser = $repUser->findOneBy(["email"=>$user]);
        $form = $this->createForm(PublicacionType::class, $publicacion,['arrayCategoria'=>$arrayCategoria]); 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $publicacion->setCategoriaId($form["categoria"]->getData()->getId());
            //seteo de variables faltantes
            $publicacion->setTrabajadorId($objUser->getId());//seteo el id del paciente quien crea la cita
           
            $publicacion->setEstado(Publicacion::ESTADO_TRUE); //estado inicial
            
            $repPublicacion->add($publicacion, true);

            //mensaje de exito
            $this->addFlash("notice","Publicación ingresada con éxito");
            return $this->redirectToRoute('app_trabajador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trabajador/new.html.twig', [
            'publicacion' => $publicacion,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id}", name="app_trabajador_show", methods={"GET"})
     */
    public function show(Publicacion $publicacion): Response
    {
        return $this->render('trabajador/show.html.twig', [
            'publicacion' => $publicacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_trabajador_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publicacion $publicacion, PublicacionRepository $publicacionRepository,ManagerRegistry $doctrine): Response
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
            return $this->redirectToRoute('app_trabajador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trabajador/edit.html.twig', [
            'publicacion' => $publicacion,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}", name="app_trabajador_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicacion $publicacion, PublicacionRepository $publicacionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicacion->getId(), $request->request->get('_token'))) {
            $publicacionRepository->remove($publicacion, true);
        }

        return $this->redirectToRoute('app_trabajador_index', [], Response::HTTP_SEE_OTHER);
    }
   
}
