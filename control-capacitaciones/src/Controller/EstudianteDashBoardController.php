<?php

namespace App\Controller;

use App\Entity\Capacitaciones;
use App\Entity\Cursos;
use App\Entity\User;
use App\Repository\CapacitacionesRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EstudianteDashBoardController extends AbstractController
{
    /**
     * @Route("/estudiante/dash/board", name="app_estudiante_dash_board")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $usuario = $request->getSession()->get('user');
        $userRepo = $doctrine->getRepository("App\Entity\User");
        $cursoRepo = $doctrine->getRepository("App\Entity\Cursos");

        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);
        $arrayCursos = $cursoRepo->getCursosSuscritos($objUsuario->getId());

        return $this->render('estudiante_dash_board/index.html.twig', [
            'cursos' =>  $arrayCursos,
        ]);
    }

    /**
     * @Route("/estudiante/dash/board/view/disponibles", name="app_estudiante_dash_board_view_disponibles")
     */
    public function viewDisponibles(Request $request, ManagerRegistry $doctrine): Response
    {
        $usuario = $request->getSession()->get('user');
        $userRepo = $doctrine->getRepository("App\Entity\User");
        $cursoRepo = $doctrine->getRepository("App\Entity\Cursos");

        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);
        $arrayCursos = $cursoRepo->getCursosDisponibles($objUsuario->getId());

        return $this->render('estudiante_dash_board/cursosDisponibles.html.twig', [
            'cursos' =>  $arrayCursos,
        ]);
    }

    /**
     * @Route("/estudiante/dash/board/{id}/{accion}/save", name="app_estudiante_dash_board_save")
     */
    public function save($id, $accion, Request $request, ManagerRegistry $doctrine): Response
    {
        $usuario = $request->getSession()->get('user');
        $userRepo = $doctrine->getRepository("App\Entity\User");
        $cursoRepo = $doctrine->getRepository("App\Entity\Cursos");
        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);
        $objCurso = new Cursos();

        if($accion == "add")
        {
            $objCurso->setCapacitacionesId($id);
            $objCurso->setUserId($objUsuario->getId());
            $objCurso->setFeCreacion(new \DateTime());
            $cursoRepo->add($objCurso,true);
        }
        elseif($accion =="delete")
        {
            $objCurso = $cursoRepo->find($id);
            $cursoRepo->remove($objCurso,true);
        }

        return $this->redirectToRoute("app_estudiante_dash_board");
    }
}

