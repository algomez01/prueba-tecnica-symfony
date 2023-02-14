<?php

namespace App\Controller;

use App\Entity\Citas;
use App\Form\CitaMedicoType;

use App\Repository\CitasRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medico/dashboard")
 */
class MedicoDashboardController extends AbstractController
{
    /**
     * @Route("/", name="app_medico_dashboard_index", methods={"GET"})
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $request->getSession()->get("user");

         //recupero repositorios
         $repoCitas = $doctrine->getRepository('App\Entity\Citas');
         $repoUsers = $doctrine->getRepository('App\Entity\User');
 
         //recupero objUser del medico
         $objUser = $repoUsers->findOneBy(["email"=>$user]);

        //generamos un nuevo metodo para mostrar los nombres del paciente en la consulta

        return $this->render('medico_dashboard/index.html.twig', [
            'citas' => $repoCitas->getCitasMedico($objUser->getId()),//solo muestra citas atendida por él
        ]);
        
    }

    /**
     * @Route("/new", name="app_medico_dashboard_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CitasRepository $citasRepository): Response
    {
        $cita = new Citas();
        $form = $this->createForm(CitaMedicoType::class, $cita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citasRepository->add($cita, true);

            return $this->redirectToRoute('app_medico_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medico_dashboard/new.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/pendiente", name="app_medico_dashboard_pendientes", methods={"GET"})
     */
    public function pendientes(Request $request, ManagerRegistry $doctrine): Response
    {
         //recupero repositorios
         $repoCitas = $doctrine->getRepository('App\Entity\Citas');

        //generamos un nuevo metodo para mostrar los nombres del paciente en la consulta

        return $this->render('medico_dashboard/citasPendientes.html.twig', [
            'citas' => $repoCitas->getCitasEstado(Citas::ESTADO_PENDIENTE),//solo muestra citas atendida por él
        ]);
    }
    /**
     * @Route("/{id}", name="app_medico_dashboard_show", methods={"GET"})
     */
    public function show(Citas $cita): Response
    {
        return $this->render('medico_dashboard/show.html.twig', [
            'cita' => $cita,
        ]);
    }
    
    /**
     * @Route("/{id}/edit", name="app_medico_dashboard_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Citas $cita,ManagerRegistry $doctrine): Response
    {
        $repoTipoCitas = $doctrine->getRepository("App\Entity\TipoCita");
        $repoCitas = $doctrine->getRepository("App\Entity\Citas");
        $repoUser = $doctrine->getRepository("App\Entity\User");

        //recuperamos usuario
        $user = $request->getSession()->get('user');
        $objUser = $repoUser->findOneBy(["email"=>$user]);

        //recupero todos tipos de citas de la tabla
        $arrayTiposCitas = $repoTipoCitas->findAll();

        $form = $this->createForm(CitaMedicoType::class, $cita,['arrayTiposCitas'=>$arrayTiposCitas]); //se los envío al form para el choice
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cita->setTipoCitaId($form["tipoCita"]->getData()->getId()); //se recupera el objeto tipo de cita y su id para almacenarlo
            $cita->setMedicoId($objUser->getId()); //setea id del medico que la atendio
            $cita->setEstado(Citas::ESTADO_ATENDIDA); //cambia a estado atendida
            $repoCitas->add($cita, true);

            $this->addFlash('notice','Cita médica atendida exitosamente');
            return $this->redirectToRoute('app_medico_dashboard_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medico_dashboard/edit.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }
    

    
    

}
