<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboradController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     *

     */
    public function index(UserRepository $reqUser): Response
    {
        $arrayUser= array();
        $arrayUser = array_merge($reqUser->findByUsersRole(User::ROLE_ADMIN),
        $reqUser->findByUsersRole(User::ROLE_PACIENTE));
        return $this->render('dashborad/index.html.twig', [
            'listUsers' => $arrayUser,
        ]);
    }
}
