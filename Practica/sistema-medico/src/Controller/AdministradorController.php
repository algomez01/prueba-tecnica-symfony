<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministradorController extends AbstractController
{
    #[Route('/administrador', name: 'app_administrador')]
    public function index(UserRepository $userRep): Response
    {
        /*array de los roles*/
        $arrayUser = array();
        $arrayUser = array_merge($userRep->findByUsersRole(User::ROLE_PACIENTE),
                                 $userRep->findByUsersRole(User::ROLE_MEDICO));

        return $this->render('administrador/index.html.twig', [
            'ListUser' => $arrayUser,
        ]);
    }
}
