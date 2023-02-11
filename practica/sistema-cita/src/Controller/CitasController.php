<?php

namespace App\Controller;

use App\Entity\Citas;
use App\Form\CitasType;
use App\Repository\CitasRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class CitasController extends AbstractController
{
    /**
     * @Route("/citas/view", name="app_citas_view")
     *
     *  @IsGranted("ROLE_PACIENTE")
     */  
    public function view(Request $request, CitasRepository $citasRep, UserRepository $userRepo): Response
    {
       
        $user = $request->getSession()->get('user');
        $userObj = $userRepo->findOneBy(["email"=>$user]);

        return $this->render('citas/index.html.twig', [
            'ListCitas' => $citasRep->findBy(["userId" => $userObj->getId()]),
        ]);
    }
    /**
     * @Route("/citas", name="app_citas")
     */
    public function index(Request $request, ManagerRegistry $doctrine, CitasRepository $citasRep, UserRepository $userRepo): Response
    {
        $citas=new Citas();
        $user = $request->getSession()->get('user');

        $objUser = $userRepo->findOneBy(["email"=>$user]);

        $form=$this->createForm(CitasType::class,$citas);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $citas=$form->getData();
            $citas->setTipoCita("EnAsignacion");
            $citas->setDuracion("00");
            $citas->setUserId($objUser->getId());
            $citasRep->save($citas,true);
        }
        return $this->render('citas/register.html.twig', [
            'Citas'=> $citas,
            'formulario' => $form->createView(),
        
        ]);
    }
    /**
     * @Route("/citas/edit/{id}", name="app_citas_edit")
     *
     * @IsGranted("ROLE_MEDICO")
     */  
    public function edit(Request $request,Citas $citas, CitasRepository $citasRep, UserRepository $userRepo): Response
    {
        $mensaje= "";
        $estado= "";
        $user = $request->getSession()->get('user');
        $objUser = $userRepo->findOneBy(["email"=>$user]);
        $form=$this->createForm(CitasType::class,$citas,array('accion'=>'editCitas'));
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $citas = $form->getData();
           
            if($estado!= "error")
            {
                $mensaje="Cita actualizado";
                $estado="exito";
                $citasRep->save($citas,true);
               
            }
            $this->addFlash('notice',$mensaje);
            return$this->redirectToRoute("app_citas");
        }
    
        return $this->render('citas/register.html.twig', [
            'Citas'=> $citas,
            'formulario' => $form->createView(),
        
        ]);
    }
    /**
     * @Route("/cita/delete/{id}", name="app_cita_delete")
     *
    
     * @IsGranted("ROLE_PACIENTE")
     */  
    public function delete( Citas $citas, CitasRepository $citasRepository): Response
    {
        $citasRepository->remove($citas, true);
        $this->addFlash("success","Cita eliminado con éxito");
        return$this->redirectToRoute("app_citas_view");
    }

}

