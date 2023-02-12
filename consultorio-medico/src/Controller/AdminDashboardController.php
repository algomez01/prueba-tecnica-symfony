<?php

namespace App\Controller;

use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="app_admin_dashboard")
     * 
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        //recupero user
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
                $this->addFlash("notice","Error en el formato de las fechas. Formato valido = dd/mm/yyyy");
            }
        }
        
        //recupero repositorios
        $repoFacturas = $doctrine->getRepository('App\Entity\Facturas');

        //function en repo para filtrar por fechas
        $arrayFacturas = $repoFacturas->getFacturasFecha($dateIni, $dateFin);

        return $this->render('admin_dashboard/index.html.twig', [
            'facturas' => $arrayFacturas,
        ]);
    }
}
