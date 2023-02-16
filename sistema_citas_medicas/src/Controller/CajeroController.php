<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Form\FacturaType;
use App\Repository\FacturaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cajero")
 */
class CajeroController extends AbstractController
{
    /**
     * @Route("/", name="app_cajero_index", methods={"GET"})
     */
    public function index(FacturaRepository $facturaRepository): Response
    {
        return $this->render('cajero/index.html.twig', [
            'facturas' => $facturaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_cajero_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FacturaRepository $facturaRepository): Response
    {
        $factura = new Factura();
        $form = $this->createForm(FacturaType::class, $factura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facturaRepository->add($factura, true);

            return $this->redirectToRoute('app_cajero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cajero/new.html.twig', [
            'factura' => $factura,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_cajero_show", methods={"GET"})
     */
    public function show(Factura $factura): Response
    {
        return $this->render('cajero/show.html.twig', [
            'factura' => $factura,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_cajero_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Factura $factura, FacturaRepository $facturaRepository): Response
    {
        $form = $this->createForm(FacturaType::class, $factura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facturaRepository->add($factura, true);

            return $this->redirectToRoute('app_cajero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cajero/edit.html.twig', [
            'factura' => $factura,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_cajero_delete", methods={"POST"})
     */
    public function delete(Request $request, Factura $factura, FacturaRepository $facturaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$factura->getId(), $request->request->get('_token'))) {
            $facturaRepository->remove($factura, true);
        }

        return $this->redirectToRoute('app_cajero_index', [], Response::HTTP_SEE_OTHER);
    }
}
