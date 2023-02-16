<?php

namespace App\Controller;

use App\Entity\Medicos;
use App\Form\MedicosType;
use App\Repository\MedicosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/medicos")
 */
class MedicosController extends AbstractController
{
    /**
     * @Route("/", name="app_medicos_index", methods={"GET"})
     */
    public function index(MedicosRepository $medicosRepository): Response
    {
        return $this->render('medicos/index.html.twig', [
            'medicos' => $medicosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_medicos_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MedicosRepository $medicosRepository): Response
    {
        $medico = new Medicos();
        $form = $this->createForm(MedicosType::class, $medico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicosRepository->add($medico, true);

            return $this->redirectToRoute('app_medicos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicos/new.html.twig', [
            'medico' => $medico,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_medicos_show", methods={"GET"})
     */
    public function show(Medicos $medico): Response
    {
        return $this->render('medicos/show.html.twig', [
            'medico' => $medico,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_medicos_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Medicos $medico, MedicosRepository $medicosRepository): Response
    {
        $form = $this->createForm(MedicosType::class, $medico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicosRepository->add($medico, true);

            return $this->redirectToRoute('app_medicos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicos/edit.html.twig', [
            'medico' => $medico,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_medicos_delete", methods={"POST"})
     */
    public function delete(Request $request, Medicos $medico, MedicosRepository $medicosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medico->getId(), $request->request->get('_token'))) {
            $medicosRepository->remove($medico, true);
        }

        return $this->redirectToRoute('app_medicos_index', [], Response::HTTP_SEE_OTHER);
    }
}
