<?php

namespace App\Controller;

use App\Entity\Publicaciones;
use App\Form\Publicaciones1Type;
use App\Form\PublicacionesType;
use App\Repository\PublicacionesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/supervisor")
 */
class SupervisorController extends AbstractController
{
    /**
     * @Route("/", name="app_supervisor_index", methods={"GET"})
     */
    public function index(PublicacionesRepository $publicacionesRepository): Response
    {
        return $this->render('supervisor/index.html.twig', [
            'publicaciones' => $publicacionesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_supervisor_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PublicacionesRepository $publicacionesRepository): Response
    {
        $publicacione = new Publicaciones();
        $form = $this->createForm(PublicacionesType::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionesRepository->add($publicacione, true);

            return $this->redirectToRoute('app_supervisor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('supervisor/new.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_supervisor_show", methods={"GET"})
     */
    public function show(Publicaciones $publicacione): Response
    {
        return $this->render('supervisor/show.html.twig', [
            'publicacione' => $publicacione,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_supervisor_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository): Response
    {
        $form = $this->createForm(Publicaciones1Type::class, $publicacione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicacionesRepository->add($publicacione, true);

            return $this->redirectToRoute('app_supervisor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('supervisor/edit.html.twig', [
            'publicacione' => $publicacione,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_supervisor_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicaciones $publicacione, PublicacionesRepository $publicacionesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicacione->getId(), $request->request->get('_token'))) {
            $publicacionesRepository->remove($publicacione, true);
        }

        return $this->redirectToRoute('app_supervisor_index', [], Response::HTTP_SEE_OTHER);
    }
}
