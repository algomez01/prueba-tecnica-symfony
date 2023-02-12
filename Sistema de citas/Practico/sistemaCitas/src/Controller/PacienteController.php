<?php

namespace App\Controller;

use App\Entity\Paciente;
use App\Form\PacienteType;
use App\Repository\PacienteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/paciente')]
class PacienteController extends AbstractController
{
    #[Route('/', name: 'app_paciente_index', methods: ['GET'])]
    public function index(PacienteRepository $pacienteRepository): Response
    {
        return $this->render('paciente/index.html.twig', [
            'pacientes' => $pacienteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_paciente_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PacienteRepository $pacienteRepository): Response
    {
        $paciente = new Paciente();
        $form = $this->createForm(PacienteType::class, $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pacienteRepository->save($paciente, true);

            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/new.html.twig', [
            'paciente' => $paciente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paciente_show', methods: ['GET'])]
    public function show(Paciente $paciente): Response
    {
        return $this->render('paciente/show.html.twig', [
            'paciente' => $paciente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_paciente_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Paciente $paciente, PacienteRepository $pacienteRepository): Response
    {
        $form = $this->createForm(PacienteType::class, $paciente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pacienteRepository->save($paciente, true);

            return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('paciente/edit.html.twig', [
            'paciente' => $paciente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_paciente_delete', methods: ['POST'])]
    public function delete(Request $request, Paciente $paciente, PacienteRepository $pacienteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paciente->getId(), $request->request->get('_token'))) {
            $pacienteRepository->remove($paciente, true);
        }

        return $this->redirectToRoute('app_paciente_index', [], Response::HTTP_SEE_OTHER);
    }
}
