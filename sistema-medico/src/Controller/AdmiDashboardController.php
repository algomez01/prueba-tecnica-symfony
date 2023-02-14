<?php

namespace App\Controller;

use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FacturasRepository;


class AdmiDashboardController extends AbstractController
{
    /**
     * @Route("/admi/dashboard", name="app_admi_dashboard")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $user = $request->getSession()->get("user");

        //recupero parametros desde el request y parse a fecha
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');
        $dateIni = null;
        $dateFin = null;

        //valida formato de las fechas ingresadas
        if($fechaInicio != null && $fechaFin != null){
            $dateIni = DateTime::createFromFormat('d/m/Y',$fechaInicio);
            $dateFin = DateTime::createFromFormat('d/m/Y',$fechaFin);
            if(!$dateIni || !$dateFin){
                $this->addFlash("notice"," Formato de fechas No vàlido. Formato valido = dd/mm/yyyy");
            }
        }
        
        //recupera el repositorio de la entidad Facturas
        $repoFactura = $doctrine->getRepository('App\Entity\Facturas');

        //function en repo para filtrar por fechas
        $arrayFactura = $repoFactura->getFacturasFechas($dateIni, $dateFin);

        return $this->render('admi_dashboard/index.html.twig', [
            'facturas' => $arrayFactura,
        ]);
    }
}
