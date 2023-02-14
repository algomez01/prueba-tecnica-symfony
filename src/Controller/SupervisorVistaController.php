<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SupervisorVistaController extends AbstractController
{
    #[Route('/supervisor/vista', name: 'app_supervisor_vista')]
    public function index(UserRepository $repUser): Response
    {
        $arrayUser = array();
        $arrayUser = array_merge($repUser->findByUserRole(User::ROLE_CAPA),
                                 $repUser->findByUserRole(User::ROLE_ESTU));

        return $this->render('supervisor_vista/index.html.twig', [
            'listUser' => $arrayUser,
        ]);
    }
}
