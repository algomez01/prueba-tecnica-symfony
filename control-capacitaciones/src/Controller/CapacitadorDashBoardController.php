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
    public function index(Request $request, CapacitacionesRepository $capacitacionesRepository, UserRepository $userRepo): Response
    {
        $user = $request->getSession()->get('user');
        $userObj = $userRepo->findOneBy(["email"=>$user]);

        return $this->render('capacitador_dash_board/index.html.twig', [
            'capacitaciones' => $capacitacionesRepository->findBy(["user_id" => $userObj->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="app_capacitador_dash_board_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CapacitacionesRepository $capacitacionesRepository, UserRepository $userRepo): Response
    {
        $capacitaciones = new Capacitaciones();
        $user = $request->getSession()->get('user');
        $userObj = $userRepo->findOneBy(["email"=>$user]);

        $form = $this->createForm(CapacitacionesType::class, $capacitaciones);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $capacitaciones->setUserId($userObj->getId());
            $capacitaciones->setEstado("EnPlanificacion");
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
        $usuario = $request->getSession()->get('user');
        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);

        $form = $this->createForm(CapacitacionesType::class, $capacitaciones, ["accion"=>"editCapacitacion"]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $capacitaciones = $form->getData();
           // $capacitacionesRepository->add($capacitaciones, true);

           if ($capacitaciones->getEstado() == "Activo") 
            {
                $totalCursos = $capacitacionesRepository->findBy(["user_id"=>$objUsuario->getId(), "estado"=>"Activo"]);

                if($totalCursos != null && count($totalCursos)>=3)
                {
                    $mensaje = "Error Solamente puede tener 3 cursos Activos";
                    $estado = "Error";
                }
            }
            elseif($capacitaciones->getEstado() == "EnPlanificacion")
            {
                $mensaje = "Error, no puede cambiar el estado EnPlanificacion";
                $estado = "Error";
            }

            if($estado != "Error")
            {
                $mensaje = "Curso Actualizado Correctamente";
                $estado = "Guardado";
                $capacitacionesRepository->add($capacitaciones,true);
            }
            $this->addFlash("notice", $mensaje);
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
