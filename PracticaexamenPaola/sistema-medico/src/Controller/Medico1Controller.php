<?php

namespace App\Controller;

use App\Entity\Cita;

use App\Form\CitaMedicoType;
use App\Repository\CitaRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medico1")
 */
class Medico1Controller extends AbstractController
{


    /**
     * @Route("/", name="app_medico_index", methods={"GET"})
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
         //recupero user
         $user = $request->getSession()->get("user");

         //recupero repositorios
         $repCita = $doctrine->getRepository('App\Entity\Cita');
         $repUser= $doctrine->getRepository('App\Entity\User');
 
         //recupero objUser del medico
         $objUser = $repUser->findOneBy(["email"=>$user]);

        //generamos un nuevo metodo para mostrar los nombres del paciente en la consulta

        return $this->render('medico/index.html.twig', [
            'citas' => $repCita->getCitasMedico($objUser->getId()),//solo muestra citas atendida por él
        ]);
    }

//nuevo controller para presentar todas las citas pendientes de atender
    /**
     * @Route("/pendientes", name="app_medico_pendientes", methods={"GET"})
     */
    public function pendientes(Request $request, ManagerRegistry $doctrine): Response
    {
         //recupero repositorios
         $repoCitas = $doctrine->getRepository('App\Entity\Cita');

        //generamos un nuevo metodo para mostrar los nombres del paciente en la consulta

        return $this->render('medico/citasPendientes.html.twig', [
            'citas' => $repoCitas->getCitaEstado(Cita::ESTADO_ENESPERA),//solo muestra citas atendida por él
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_medico_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cita $cita,ManagerRegistry $doctrine): Response
    {
        $repTipoCita = $doctrine->getRepository("App\Entity\TipoCita");
        $repCita = $doctrine->getRepository("App\Entity\Cita");
        $repUser = $doctrine->getRepository("App\Entity\User");

        //recuperamos usuario
        $user = $request->getSession()->get('user');
        $objUser = $repUser->findOneBy(["email"=>$user]);

        //recupero todos tipos de citas de la tabla
        $arrayTipoCita = $repTipoCita->findAll();

        $form = $this->createForm(CitaMedicoType::class, $cita,['arrayTipoCita'=>$arrayTipoCita]); //se los envío al form para el choice
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cita->setTipoCitaId($form["tipoCita"]->getData()->getId()); //se recupera el objeto tipo de cita y su id para almacenarlo
            $cita->setDoctorId($objUser->getId()); //setea id del medico que la atendio
            $cita->setEstado(Cita::ESTADO_ATENDIDA); //cambia a estado atendida
            $repCita->add($cita, true);

            $this->addFlash('notice','Cita médica atendida');
            return $this->redirectToRoute('app_medico_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medico/edit.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}", name="app_medico_delete", methods={"POST"})
     */
    public function delete(Request $request, Cita $cita, CitaRepository $citasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cita->getId(), $request->request->get('_token'))) {
            $citasRepository->remove($cita, true);
        }

        return $this->redirectToRoute('app_medico_index', [], Response::HTTP_SEE_OTHER);
    }
}
