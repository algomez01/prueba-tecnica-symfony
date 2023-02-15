<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administrador")
 */
class AdministradorController extends AbstractController
{
    
    /**
     * @Route("/administradorlist", name="app_administrador_index", methods={"GET"})
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        return $this->render('administrador/index.html.twig', [
            'categorias' => $categoriaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_administrador_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CategoriaRepository $categoriaRepository): Response
    {
        $categorium = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriaRepository->add($categorium, true);

            return $this->redirectToRoute('app_administrador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('administrador/new.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_administrador_show", methods={"GET"})
     */
    public function show(Categoria $categorium): Response
    {
        return $this->render('administrador/show.html.twig', [
            'categorium' => $categorium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_administrador_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categoria $categorium, CategoriaRepository $categoriaRepository): Response
    {
        $form = $this->createForm(CategoriaType::class, $categorium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoriaRepository->add($categorium, true);

            return $this->redirectToRoute('app_administrador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('administrador/edit.html.twig', [
            'categorium' => $categorium,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_administrador_delete", methods={"POST"})
     */
    public function delete(Request $request, Categoria $categorium, CategoriaRepository $categoriaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorium->getId(), $request->request->get('_token'))) {
            $categoriaRepository->remove($categorium, true);
        }

        return $this->redirectToRoute('app_administrador_index', [], Response::HTTP_SEE_OTHER);
    }
}
