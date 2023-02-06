<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/course', name: 'app_course')]
    public function index(Request $request, CourseRepository $courseRep): Response
    {
        $user=$request->getUser();

        return $this->render('course/index.html.twig', [
            'ListCourse' => $courseRep->findAll(),
        ]);
    }
    #[Route('/registration/curso', name: 'app_registration')]
    public function register(Request $request, CourseRepository $CourseRep): Response
    {
        $course=new Course();
        $form=$this->createForm(CourseType::class,$course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $course=$form->getData();
            $CourseRep->add($course,true);
            $this->addFlash("sucess","Registro del curso exitoso");
        }
        return $this->render('course/register.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
