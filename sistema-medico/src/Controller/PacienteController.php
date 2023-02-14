<?php

namespace App\Controller;

use App\Entity\Citas;
use App\Form\CitasType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CitasRepository;

class PacienteController extends AbstractController
{
    /**
     * @Route("/", name="app_paciente_dashboard_index", methods={"GET"})
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repoCita = $doctrine->getRepository('App\Entity\Citas');
        $repoUsers = $doctrine->getRepository('App\Entity\User');

        //recupero objUser
        $objUser = $repoUsers->findOneBy(["email"=>$user]);

        //Se crea método en repositorio para recuperar el nombre del médico en vez del id
        $arrayCita = $repoCita->getCitasUsuario($objUser->getId());

        return $this->render('paciente/index.html.twig', [
            'citas' => $arrayCita, //consulta solo citas del usuario logueado
        ]);
    }
/**
     * @Route("/new", name="app_paciente_dashboard_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $cita = new Citas();
        $form = $this->createForm(CitasType::class, $cita);
        $form->handleRequest($request);

        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repoCitas = $doctrine->getRepository('App\Entity\Citas');
        $repoUsers = $doctrine->getRepository('App\Entity\User');

        //recupero objUser
        $objUser = $repoUsers->findOneBy(["email"=>$user]);

        if ($form->isSubmitted() && $form->isValid()) {
            //seteo de variables faltantes
            $cita->setPacienteId($objUser->getId());//seteo el id del paciente quien crea la cita
            $cita->setFeCreacion(new \DateTime()); //fecha del sistema
            $cita->setEstado(Citas::ESTADO_PENDIENTE); //estado inicial
            
            $repoCitas->add($cita, true);


            //mensaje de que se ingreso correctamente la cita 
            $this->addFlash("notice","Cita ingresada ");
            return $this->redirectToRoute('app_paciente_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/new.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_paciente_dashboard_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Citas $cita, CitasRepository $citasRepository): Response
    {
        $form = $this->createForm(CitasType::class, $cita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //cuando se actualiza se refresca su hora de creacion
            $cita->setFeCreacion(new \DateTime()); //fecha del sistema
            $citasRepository->add($cita, true);

            $this->addFlash("notice","Cita actualizada con éxito");
            return $this->redirectToRoute('app_paciente_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/edit.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_paciente_dashboard_delete", methods={"POST"})
     */
    public function delete(Request $request, Citas $cita, CitasRepository $citasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cita->getId(), $request->request->get('_token'))) {
            $citasRepository->remove($cita, true);
        }

        return $this->redirectToRoute('app_paciente_dashboard_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
