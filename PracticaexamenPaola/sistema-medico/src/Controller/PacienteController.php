<?php

namespace App\Controller;

use App\Entity\Cita;
use App\Form\CitaType;
use App\Repository\CitaRepository;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paciente")
 */
class PacienteController extends AbstractController
{
   
     /**
     * @Route("/paciente", name="app_paciente_index"), methods={"GET"})
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repCita = $doctrine->getRepository('App\Entity\Cita');
        $repUser = $doctrine->getRepository('App\Entity\User');

        //recupero objUser
        $objUser = $repUser->findOneBy(["email"=>$user]);

        //creamos nuevo método en repositorio para recuperar el nombre del médico en vez del id
        $arrayCitas = $repCita->getCitaUser($objUser->getId());

        return $this->render('paciente/index.html.twig', [
            'citas' => $arrayCitas, //consulta solo citas del usuario logueado
        ]);
    }

    /**
     * @Route("/new", name="app_paciente_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $cita = new Cita();
        $form = $this->createForm(CitaType::class, $cita);
        $form->handleRequest($request);

        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repCita = $doctrine->getRepository('App\Entity\Cita');
        $repUser = $doctrine->getRepository('App\Entity\User');

        //recupero objUser
        $objUser = $repUser->findOneBy(["email"=>$user]);

        if ($form->isSubmitted() && $form->isValid()) {
            //seteo de variables faltantes
            $cita->setPacienteId($objUser->getId());//seteo el id del paciente quien crea la cita
            $cita->setFechaCreacion(new \DateTime()); //fecha del sistema
            $cita->setEstado(Cita::ESTADO_ENESPERA); //estado inicial
            
            $repCita->add($cita, true);

            //mensaje de exito
            $this->addFlash("notice","Cita ingresada con éxito");
            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/new.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_paciente_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cita $cita, CitaRepository $citasRepository): Response
    {
        $form = $this->createForm(CitaType::class, $cita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //cuando se actualiza se refresca su hora de creacion
            $cita->setFechaCreacion(new \DateTime()); //fecha del sistema
            $citasRepository->add($cita, true);

            $this->addFlash("notice","Cita actualizada ");
            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/edit.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_paciente_delete", methods={"POST"})
     */
    public function delete(Request $request, Cita $cita, CitaRepository $citasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cita->getId(), $request->request->get('_token'))) {
            $citasRepository->remove($cita, true);
        }

        return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
    }
}


