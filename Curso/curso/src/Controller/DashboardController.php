<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(UserRepository $reqUser): Response
    {
        $arrayUser= array();
        $arrayUser = array_merge($reqUser->findByUsersRole(User::ROLE_ESTUDIANTES),
        $reqUser->findByUsersRole(User::ROLE_INSTRUCTOR));
        return $this->render('dashboard/index.html.twig', [
            'listUsers' => '$arrayUser',
        ]);
    }
}
