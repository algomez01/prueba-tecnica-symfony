<?php

namespace App\Controller;

use App\Entity\Medico;
use App\Form\MedicoType;
use App\Repository\MedicoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/medico')]
class MedicoController extends AbstractController
{
    #[Route('/', name: 'app_medico_index', methods: ['GET'])]
    public function index(MedicoRepository $medicoRepository): Response
    {
        return $this->render('medico/index.html.twig', [
            'medicos' => $medicoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medico_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MedicoRepository $medicoRepository): Response
    {
        $medico = new Medico();
        $form = $this->createForm(MedicoType::class, $medico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicoRepository->save($medico, true);

            return $this->redirectToRoute('app_medico_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medico/new.html.twig', [
            'medico' => $medico,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medico_show', methods: ['GET'])]
    public function show(Medico $medico): Response
    {
        return $this->render('medico/show.html.twig', [
            'medico' => $medico,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medico_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medico $medico, MedicoRepository $medicoRepository): Response
    {
        $form = $this->createForm(MedicoType::class, $medico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $medicoRepository->save($medico, true);

            return $this->redirectToRoute('app_medico_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medico/edit.html.twig', [
            'medico' => $medico,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medico_delete', methods: ['POST'])]
    public function delete(Request $request, Medico $medico, MedicoRepository $medicoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medico->getId(), $request->request->get('_token'))) {
            $medicoRepository->remove($medico, true);
        }

        return $this->redirectToRoute('app_medico_index', [], Response::HTTP_SEE_OTHER);
    }
}
