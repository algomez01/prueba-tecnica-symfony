<?php

namespace App\Controller;

use App\Entity\Capacitaciones;
use App\Repository\CapacitacionesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CapacitadorDahsBoardController extends AbstractController
{
    /**
     * @Route("/capacitador/dahs/board", name="app_capacitador_dahs_board")
     */
    public function index(Request $request, CapacitacionesRepository $capacitacionesRep): Response
    {
        #$user = $request->getUser();
        return $this->render('capacitador_dahs_board/index.html.twig', [
            'listCapacitaciones' => $capacitacionesRep->findAll(),
        ]);
    }
    /**
     * @Route("/capacitador/dahs/board/register", name="app_capacitador_dahs_board_register")
     */
    public function register(Request $request, CapacitacionesRepository $capacitacionesRep): Response
    {
        $capacitaciones = new Capacitaciones(2);
        $form = $this->createForm(RegisterCapacitacionesType::class, $capacitaciones);
        $form-> handleRequest($request);

        if($form->isSubmitted() && $form->isValid){
            $capacitaciones =$form->getData();
            $capacitaciones ->setUserId(3);
            $capacitacionesRep->add($capacitaciones,true);
            $this->addFlash("success","Registro del Curso exitoso");
            return $this->redirectToRoute('app_capacitador_dahs_board');
        }

        return $this->render('capacitador_dahs_board/registerCapacitaciones.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
