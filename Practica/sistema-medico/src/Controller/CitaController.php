<?php

namespace App\Controller;

use App\Entity\Cita;
use App\Form\CitaType;
use App\Repository\CitaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CitaController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_cita")
     * 
     */
   
    public function index(Request $request, CitaRepository $citaRep, UserRepository $userRepo): Response
    {
        $user = $request->getSession()->get('user');
        $userObj = $userRepo->findOneBy(["email"=>$user]);
        
        
        return $this->render('cita/index.html.twig', [
            'ListCitas' => $citaRep->findBy(["userId" => $userObj->getId()]),
        ]);
    }
    
    /**
      * @Route("/registration/cita", name="app_cita_nuevo")
      */
    
      public function register(Request $request,CitaRepository $citaRep, UserRepository $userRepo): Response
    {
        $cita=new Cita();
        $user = $request->getSession()->get('user');

        $objUser = $userRepo->findOneBy(["email"=>$user]);

        $form=$this->createForm(CitaType::class,$cita);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cita=$form->getData();
            $fecha = $form->get('Fecha')->getData();
            $cita->setFecha($fecha);
            $cita->setUserId($objUser->getId());
           
            $citaRep->save($cita,true);
            
            $this->addFlash("sucess","Registro de curso exitoso");
            return$this->redirectToRoute("app_cita");
        }
        return $this->render('cita/Register.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
    /**
      * @Route("/dashboard/{id}/edit", name="app_cita_edit")
      */
      public function edit(Request $request,Cita $cita, CitaRepository $citaRep, UserRepository $userRepo): Response
      {
          $mensaje= "";
          $estado= "";
         
          $user = $request->getSession()->get('user');
          $objUser = $userRepo->findOneBy(["email"=>$user]);
          $form=$this->createForm(CitaType::class,$cita,array('accion'=>'editCurso'));
          $form->handleRequest($request);
          if($form->isSubmitted()&& $form->isValid())
          {
              $cita = $form->getData();
              $fecha = $form->get('Fecha')->getData();
              $cita->setFecha($fecha);
                 
              $citaRep->save($cita,true);
              $this->addFlash('notice',$mensaje);
              return$this->redirectToRoute("app_cita");
          }
          return $this->render('cita/Register.html.twig', [
              'Cita'=> $cita,
              'formulario' => $form->createView(),
          ]);
        }  
    /**
     * @Route("/{id}/delete", name="app_cita_delete")
     */      
    
    public function delete( Cita $cita, CitaRepository $citaRepository): Response
    {
        $citaRepository->remove($cita, true);
        $this->addFlash("success","Cita eliminado con éxito");
        return$this->redirectToRoute("app_cita");
    }

}




