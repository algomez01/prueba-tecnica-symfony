<?php

namespace App\Controller;

use App\Entity\Citas;
use App\Form\CitasType;
use App\Repository\CitasRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/registro/citas")
 */
class RegistroCitasController extends AbstractController
{
    /**
     * @Route("/", name="app_registro_citas_index", methods={"GET"})
     */
    public function index(CitasRepository $citasRepository, Request $request, ManagerRegistry $doctrine): Response
    {
        //Recuperar user
        $user = $request->getSession()->get('user');

        //Recuperar repositorios
        $citasRepository = $doctrine->getRepository('App\Entity\Citas');
        $UserRepository = $doctrine->getRepository('App\Entity\User');

        //Recuperar objeto User
        $objUser = $UserRepository->findOneBy(['email' => $user]);

        //Creamos nuevo método en repositorio para recuperar el método del médico en vez del id
        


        return $this->render('registro_citas/index.html.twig', [
            'citas' => $citasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_registro_citas_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CitasRepository $citasRepository): Response
    {
        $cita = new Citas();
        $form = $this->createForm(CitasType::class, $cita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citasRepository->add($cita, true);

            return $this->redirectToRoute('app_registro_citas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('registro_citas/new.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_registro_citas_show", methods={"GET"})
     */
    public function show(Citas $cita): Response
    {
        return $this->render('registro_citas/show.html.twig', [
            'cita' => $cita,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_registro_citas_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Citas $cita, CitasRepository $citasRepository): Response
    {
        $form = $this->createForm(CitasType::class, $cita);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citasRepository->add($cita, true);

            return $this->redirectToRoute('app_registro_citas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('registro_citas/edit.html.twig', [
            'cita' => $cita,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_registro_citas_delete", methods={"POST"})
     */
    public function delete(Request $request, Citas $cita, CitasRepository $citasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cita->getId(), $request->request->get('_token'))) {
            $citasRepository->remove($cita, true);
        }

        return $this->redirectToRoute('app_registro_citas_index', [], Response::HTTP_SEE_OTHER);
    }
}
