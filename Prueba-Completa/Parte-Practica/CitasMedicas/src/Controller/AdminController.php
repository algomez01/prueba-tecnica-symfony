<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    //El método "index" tiene como parámetro una dependencia "UserRepository", 
     //que es una clase que se encarga de hacer consultas a la base de datos relacionadas con los usuarios.

    public function index(UserRepository $repUser): Response
    {
        //se crea un array vacío llamado "arrayUser", y luego se llena con los resultados de dos llamadas al método "findByUsersRole" de la clase "UserRepository".
        /*array de los roles*/
        $arrayUser = array();
        $arrayUser = array_merge($repUser->findByUsersRole(User::ROLE_PACIENTE),
                                $repUser->findByUsersRole(User::ROLE_CAJA),
                                 $repUser->findByUsersRole(User::ROLE_MEDICO));
        return $this->render('admin/index.html.twig', [
            'listUsers' => $arrayUser,
        ]);
    }
}
