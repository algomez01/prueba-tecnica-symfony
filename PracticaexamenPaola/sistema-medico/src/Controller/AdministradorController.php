<?php

namespace App\Controller;

use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministradorController extends AbstractController
{
    /**
     * @Route("/administrador", name="app_administrador")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
        $user = $request->getSession()->get("user");

        //recupero parametros desde el request y parse a fecha
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');
        $dateInicio = null;
        $dateFin = null;

        //valida formato de las fechas ingresadas
        if($fechaInicio != null && $fechaFin != null){
            $dateInicio = DateTime::createFromFormat('d/m/Y',$fechaInicio);
            $dateFin = DateTime::createFromFormat('d/m/Y',$fechaFin);
            if(!$dateInicio || !$dateFin){
                $this->addFlash("notice","Error  Formato valido = dd/mm/yyyy");
            }
        }
        
        //recupero repositorios
        $repFactura = $doctrine->getRepository('App\Entity\Factura');

        //function en repo para filtrar por fechas
        $arrayFactura = $repFactura->getFacturasFecha($dateInicio, $dateFin);

        return $this->render('administrador/index.html.twig', [
            'facturas' => $arrayFactura,
        ]);
    }
}


