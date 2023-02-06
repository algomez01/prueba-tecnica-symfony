<?php

namespace App\Controller;

use App\Entity\Curso;
use App\Form\CursoType;
use App\Repository\CursoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CursoController extends AbstractController
{
    
    
        #[Route('/dashboard', name: 'app_curso_dashboard')]
        public function index(Request $request, CursoRepository $cursoRep): Response
        {
            $user=$request->getUser();
    
            return $this->render('curso/index.html.twig', [
                'ListCursos' => $cursoRep->findAll(),
            ]);
        }
        #[Route('/registration/curso', name: 'app_curso_nuevo')]
        public function register(Request $request,  CursoRepository $cursoRep): Response
        {
            $curso=new Curso();
            $form=$this->createForm(CursoType::class,$curso);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $curso=$form->getData();
                $cursoRep->add($curso,true);
                $this->addFlash("sucess","Registro de curso exitoso");
            }
            return $this->render('curso/Register.html.twig', [
                'formulario' => $form->createView(),
            ]);
        }
        #[Route('/{id}/edit', name: 'app_curso_edit', methods: ['GET', 'POST'])]
        public function edit(Request $request, Curso $curso,  CursoRepository $cursoRep): Response
        {
            $form = $this->createForm(CursoType::class, $curso);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $cursoRep->save($curso, true);
    
                return $this->redirectToRoute('app_curso_dashboard', [], Response::HTTP_SEE_OTHER);
            }
    
            return $this->renderForm('curso/index.html.twig', [
                'curso' => $curso,
                'form' => $form,
            ]);
        }
        #[Route('/{id}/delete', name: 'app_curso_delete', methods: ['POST'])]
        public function delete(Request $request, Curso $curso,  CursoRepository $cursoRep): Response
        {
            if ($this->isCsrfTokenValid('delete'.$curso->getId(), $request->request->get('_token'))) {
                $cursoRep->remove($curso, true);
            }
    
            return $this->redirectToRoute('app_curso_dashboard', [], Response::HTTP_SEE_OTHER);
        }
    }
    

