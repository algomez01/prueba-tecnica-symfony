<?php

namespace App\Controller;

use App\Entity\Capacitaciones;
use App\Repository\CapacitacionesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstudianteDashBoardController extends AbstractController
{
    /**
     * @Route("/estudiante/dash/board", name="app_estudiante_dash_board")
     */
    public function index(CapacitacionesRepository $capacitacionesRepository): Response
    {
        return $this->render('estudiante_dash_board/index.html.twig', [
            'capacitaciones' =>  $capacitacionesRepository->findAll(),
        ]);
    }
}

