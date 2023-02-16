<?php

namespace App\Controller;

use App\Entity\TipoCita;
use App\Form\TipoCitaType;
use App\Repository\TipoCitaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/cita")
 */
class TipoCitaController extends AbstractController
{
    /**
     * @Route("/", name="app_tipo_cita_index", methods={"GET"})
     */
    public function index(TipoCitaRepository $tipoCitaRepository): Response
    {
        return $this->render('tipo_cita/index.html.twig', [
            'tipo_citas' => $tipoCitaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_tipo_cita_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TipoCitaRepository $tipoCitaRepository): Response
    {
        $tipoCitum = new TipoCita();
        $form = $this->createForm(TipoCitaType::class, $tipoCitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tipoCitaRepository->add($tipoCitum, true);

            return $this->redirectToRoute('app_tipo_cita_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tipo_cita/new.html.twig', [
            'tipo_citum' => $tipoCitum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tipo_cita_show", methods={"GET"})
     */
    public function show(TipoCita $tipoCitum): Response
    {
        return $this->render('tipo_cita/show.html.twig', [
            'tipo_citum' => $tipoCitum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_tipo_cita_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TipoCita $tipoCitum, TipoCitaRepository $tipoCitaRepository): Response
    {
        $form = $this->createForm(TipoCitaType::class, $tipoCitum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tipoCitaRepository->add($tipoCitum, true);

            return $this->redirectToRoute('app_tipo_cita_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tipo_cita/edit.html.twig', [
            'tipo_citum' => $tipoCitum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_tipo_cita_delete", methods={"POST"})
     */
    public function delete(Request $request, TipoCita $tipoCitum, TipoCitaRepository $tipoCitaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoCitum->getId(), $request->request->get('_token'))) {
            $tipoCitaRepository->remove($tipoCitum, true);
        }

        return $this->redirectToRoute('app_tipo_cita_index', [], Response::HTTP_SEE_OTHER);
    }
}
