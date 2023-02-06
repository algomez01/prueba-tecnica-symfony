<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashBoardController extends AbstractController
{
    /**
     * @Route("/admin/dash/board", name="app_admin_dash_board")
     */
    public function index(UserRepository $repUser): Response
    {
        /*array de los roles*/
        $arrayUser = array();
        $arrayUser = array_merge($repUser->findByUsersRole(User::ROLE_ESTUDIANTE),
                                 $repUser->findByUsersRole(User::ROLE_CAPACITADOR));

        return $this->render('admin_dash_board/index.html.twig', [
            'listUsers' => $arrayUser,
        ]);
    }
}
