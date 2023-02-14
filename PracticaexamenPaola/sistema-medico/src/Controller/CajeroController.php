<?php

namespace App\Controller;

use App\Entity\Cita;
use App\Entity\Factura;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CajeroController extends AbstractController
{
    /**
     * @Route("/cajero", name="app_cajero")
     */
    
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");

        //recupero repositorios
        $repFactura = $doctrine->getRepository('App\Entity\Factura');
        $repUser = $doctrine->getRepository('App\Entity\User');

        //recupero objUser del cajero
        $objUser = $repUser->findOneBy(["email"=>$user]);

        //generamos nuevo function en repo para buscar facturas creadas por él
        $arrayFacturas = $repFactura->getFacturasUsuario($objUser->getId());

        return $this->render('cajero/index.html.twig', [
            'facturas' => $arrayFacturas,
        ]);
    }

    /**
     * @Route("/cajero/dashboard/atendidas", name="app_cajero_atendida", methods={"GET"})
     */
    public function atendidas(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero repositorios
        $repoCitas = $doctrine->getRepository('App\Entity\Cita');

        //recupero citas atendidas, pendientes de facturar
        $arrayCitas = $repoCitas->getCitaEstado(Cita::ESTADO_ATENDIDA);

        return $this->render('cajero/citasAtend.html.twig', [
            'citas' => $arrayCitas,
        ]);
    }

    /**
     * @Route("/cajero/dashboard/{id}/facturar", name="app_cajero_facturar", methods={"GET"})
     */
    public function facturar(Cita $cita, Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");
        $factura = new Factura();

        //recupero repositorios
        $repoCitas = $doctrine->getRepository('App\Entity\Cita');
        $repoFacturas = $doctrine->getRepository('App\Entity\Factura');
        $repoTipoCita = $doctrine->getRepository('App\Entity\TipoCita');
        $repoUsers = $doctrine->getRepository('App\Entity\User');

        //recupero objUser del cajero
        $objUser = $repoUsers->findOneBy(["email"=>$user]);

        //recupero el valor del tipo de cita
        $tipoCita = $repoTipoCita->find($cita->getTipoCitaId());

        //genero y guardo nueva factura
        $factura->setCajeroId($objUser->getId());
        $factura->setCitaId($cita->getId());
        $factura->setFechaCreacion(new \DateTime());
        $factura->setTotalpagar($tipoCita->getValor());

        $repoFacturas->add($factura,true);

        //cambia de estado a la cita médica
        $cita->setEstado(Cita::ESTADO_FACTURADA);
        $repoCitas->add($cita,true);

        return $this->redirectToRoute('app_cajero');
    }
}


