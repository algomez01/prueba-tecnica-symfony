<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InstructorController extends AbstractController
{
    #[Route('/instructor', name: 'app_instructor')]
    
    public function index(UserRepository $reqUser): Response
    {
        $arrayUser= array();
        $arrayUser = array_merge($reqUser->findByUsersRole(User::ROLE_INSTRUCTOR),
        $reqUser->findByUsersRole(User::ROLE_ESTUDINATE));
        return $this->render('instructor/index.html.twig', [
            'listUsers' => '$arrayUser',
        ]);
    }
}
