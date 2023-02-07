<?php

namespace App\Controller;

use App\Entity\Capacitaciones;
use App\Form\CapacitacionesType;
use App\Repository\CapacitacionesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/capacitador/dash/board")
 */
class CapacitadorDashBoardController extends AbstractController
{
    /**
     * @Route("/", name="app_capacitador_dash_board_index", methods={"GET"})
     */
    public function index(CapacitacionesRepository $capacitacionesRepository): Response
    {
        return $this->render('capacitador_dash_board/index.html.twig', [
            'capacitaciones' => $capacitacionesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_capacitador_dash_board_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CapacitacionesRepository $capacitacionesRepository): Response
    {
        $capacitaciones = new Capacitaciones();
        $form = $this->createForm(CapacitacionesType::class, $capacitaciones);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $capacitacionesRepository->add($capacitaciones, true);

            return $this->redirectToRoute('app_capacitador_dash_board_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('capacitador_dash_board/new.html.twig', [
            'capacitaciones' => $capacitaciones,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_capacitador_dash_board_show", methods={"GET"})
     */
    public function show(Capacitaciones $capacitaciones): Response
    {
        return $this->render('capacitador_dash_board/show.html.twig', [
            'capacitaciones' => $capacitaciones,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_capacitador_dash_board_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Capacitaciones $capacitaciones, CapacitacionesRepository $capacitacionesRepository, UserRepository $userRepo): Response
    {
        $mensaje="";
        $estado="";
        $usuario= $request->getUser();
        $usuario="Example@mail.com";
        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);

        $form = $this->createForm(CapacitacionesType::class, $capacitaciones);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $capacitaciones = $form->getData();
           // $capacitacionesRepository->add($capacitaciones, true);

           if ($objUsuario) 
            {
                $totalCursos = $capacitacionesRepository->totalByUserIdAndEstado($objUsuario->getId(),"Activo");

                if($totalCursos != null && $totalCursos >= 2)
                {
                    $mensaje = "Error Solamente puede tener 3 cursos Activos";
                    $estado = "Error";
                }
            }
            elseif($capacitaciones->getEstado() == "EnPlanificacion")
            {
                $mensaje = "Error, no puede cambiar el estado";
                $estado = "Error";
            }

            if($estado != "error")
            {
                $mensaje = "Curso Actualizado Correctamente";
                $estado = "Guardado";
                $capacitacionesRepository->add($capacitaciones,true);
            }
            $this->addFlash($estado, $mensaje);
            return $this->redirectToRoute('app_capacitador_dash_board_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('capacitador_dash_board/edit.html.twig', [
            'capacitaciones' => $capacitaciones,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_capacitador_dash_board_delete", methods={"POST"})
     */
    public function delete(Request $request, Capacitaciones $capacitaciones, CapacitacionesRepository $capacitacionesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$capacitaciones->getId(), $request->request->get('_token'))) {
            $capacitacionesRepository->remove($capacitaciones, true);
        }
    
        return $this->redirectToRoute('app_capacitador_dash_board_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
