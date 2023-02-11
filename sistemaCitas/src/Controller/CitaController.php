<?php

namespace App\Controller;

use App\Entity\Cita;
use App\Form\CitaType;
use App\Repository\CitaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cita')]
class CitaController extends AbstractController
{
    #[Route('/', name: 'app_cita_index', methods: ['GET'])]
    public function index(CitaRepository $citaRepository): Response
    {
        return $this->render('cita/index.html.twig', [
            'citas' => $citaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cita_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CitaRepository $citaRepository): Response
    {
        $citum = new Cita();
        $form = $this->createForm(CitaType::class, $citum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citaRepository->save($citum, true);

            return $this->redirectToRoute('app_cita_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cita/new.html.twig', [
            'citum' => $citum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cita_show', methods: ['GET'])]
    public function show(Cita $citum): Response
    {
        return $this->render('cita/show.html.twig', [
            'citum' => $citum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cita_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cita $citum, CitaRepository $citaRepository): Response
    {
        $form = $this->createForm(CitaType::class, $citum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $citaRepository->save($citum, true);

            return $this->redirectToRoute('app_cita_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cita/edit.html.twig', [
            'citum' => $citum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cita_delete', methods: ['POST'])]
    public function delete(Request $request, Cita $citum, CitaRepository $citaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$citum->getId(), $request->request->get('_token'))) {
            $citaRepository->remove($citum, true);
        }

        return $this->redirectToRoute('app_cita_index', [], Response::HTTP_SEE_OTHER);
    }
}
