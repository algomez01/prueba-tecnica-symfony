<?php

namespace App\Controller;

use App\Entity\Citas;
use App\Entity\Facturas;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CajeroController extends AbstractController
{
   /**
     * @Route("/cajero/dashboard", name="app_cajero_dashboard")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repoFacturas = $doctrine->getRepository('App\Entity\Facturas');
        $repoUsers = $doctrine->getRepository('App\Entity\User');



        //Se recupera objUser del cajero
        $objUser = $repoUsers->findOneBy(["email"=>$user]);

        //generamos nuevo function en repo para buscar facturas creadas por él
        $arrayFacturas = $repoFacturas->getFacturasUsuario($objUser->getId());

        return $this->render('cajero/index.html.twig', [
            'facturas' => $arrayFacturas,
        ]);
    }

    /**
     * @Route("/cajero/dashboard/atendidas", name="app_cajero_dashboard_atendidas", methods={"GET"})
     */
    public function atendidas(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero repositorios
        $repoCitas = $doctrine->getRepository('App\Entity\Citas');

        //recupero citas atendidas, pendientes de facturar
        $arrayCitas = $repoCitas->getCitasEstado(Citas::ESTADO_ATENDIDA);

        return $this->render('cajero/citasAtendidas.html.twig', [
            'citas' => $arrayCitas,
        ]);
    }

    /**
     * @Route("/cajero/dashboard/{id}/facturar", name="app_cajero_facturar", methods={"GET"})
     */
    public function facturar(Citas $cita, Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");
        $factura = new Facturas();

        //recupero repositorios
        $repoCitas = $doctrine->getRepository('App\Entity\Citas');
        $repoFacturas = $doctrine->getRepository('App\Entity\Facturas');
        $repoTipoCita = $doctrine->getRepository('App\Entity\TipoCita');
        $repoUsers = $doctrine->getRepository('App\Entity\User');

        //recupero objUser del cajero
        $objUser = $repoUsers->findOneBy(["email"=>$user]);

        //recupero el valor del tipo de cita
        $tipoCita = $repoTipoCita->find($cita->getTipoCitaId());

        //genero y guardo nueva factura
        $factura->setCajeroId($objUser->getId());
        $factura->setCitaId($cita->getId());
        $factura->setFeCreacion(new \DateTime());
        $factura->setTotal($tipoCita->getCosto());

        $repoFacturas->add($factura,true);

        //cambia de estado a la cita médica
        $cita->setEstado(Citas::ESTADO_FACTURADA);
        $repoCitas->add($cita,true);

        return $this->redirectToRoute('app_cajero_dashboard');
    }
}