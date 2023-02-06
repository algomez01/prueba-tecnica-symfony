<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstudiantesController extends AbstractController
{
    #[Route('/estudiantes', name: 'app_estudiantes')]
    public function index(): Response
    {
        return $this->render('estudiantes/index.html.twig', [
            'controller_name' => 'EstudiantesController',
        ]);
    }
}
