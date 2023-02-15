<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioExternoController extends AbstractController
{
    /**
     * @Route("/usuario/externo", name="app_usuario_externo")
     */
    public function index(): Response
    {
        return $this->render('usuario_externo/index.html.twig', [
            'controller_name' => 'UsuarioExternoController',
        ]);
    }
}
