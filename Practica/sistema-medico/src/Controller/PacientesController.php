<?php

namespace App\Controller;

use App\Entity\Cita;
use App\Entity\Test;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PacientesController extends AbstractController
{
   /**
     * @Route("/pacientes/dash/board", name="app_paciente_dash_board")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $usuario = $request->getSession()->get('user');
        $userRepo = $doctrine->getRepository("App\Entity\User");
        $citaRepo = $doctrine->getRepository("App\Entity\Cita");

        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);
        $arrayCita = $citaRepo->getCitasSuscritos($objUsuario->getId());

        return $this->render('pacientes/index.html.twig', [
            'citas' =>  $arrayCita,
        ]);
    }

    /**
     * @Route("/paciente/dash/board/view/disponibles", name="app_paciente_dash_board_view_disponibles")
     */
    public function viewDisponibles(Request $request, ManagerRegistry $doctrine): Response
    {
        $usuario = $request->getSession()->get('user');
        $userRepo = $doctrine->getRepository("App\Entity\User");
        $citaRepo = $doctrine->getRepository("App\Entity\Cita");

        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);
        $arrayCitas = $citaRepo->getCitasDisponibles($objUsuario->getId());

        return $this->render('pacientes/citasDisponibles.html.twig', [
            'citas' =>  $arrayCitas,
        ]);
    }

    /**
     * @Route("/paciente/dash/board/{id}/{accion}/save", name="app_paciente_dash_board_save")
     */
    public function save($id, $accion, Request $request, ManagerRegistry $doctrine): Response
    {
        //$entityManager = $doctrine->getManager();
        $usuario = $request->getSession()->get('user');
        $userRepo = $doctrine->getRepository("App\Entity\User");
        $testRepo = $doctrine->getRepository("App\Entity\Test");
        //$cursoRepo = $doctrine->getRepository("App\Entity\Curso");
        $objUsuario = $userRepo->findOneBy(["email"=>$usuario]);
        $objTest = new Test();

        if($accion == "add")
        {
            
            $objTest->setUserId($objUsuario->getId());
            $testRepo->add($objTest,true);
        }
        elseif($accion =="delete")
        {
            $entityManager = $doctrine->getManager();
            $objToDelete = $testRepo->findOneBy([ "userId" => $objUsuario->getId()]);
            $entityManager->remove($objToDelete);
            $entityManager->flush();
            //$objTest = $testRepo->findOneBy(["cursoId" => $id, "userId" => $objUsuario->getId()]);
            //$testRepo->remove($objTest);
            //$objTest->setUserId($objUsuario->getId());
            //$objTest->getCursoId($id);
            //$objTest->getUserId();
            //$objTest = $testRepo->find($id);
           //$product = $entityManager->getRepository(Product::class)->find($id);
           //$testRepo->remove($objTest,true);
        }

        return $this->redirectToRoute("app_paciente_dash_board");
    }
}




