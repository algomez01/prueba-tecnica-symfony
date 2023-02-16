<?php

namespace App\Controller;

use App\Entity\Facturas;
use App\Form\FacturacionType;
use App\Repository\FacturasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facturacion")
 */
class FacturacionController extends AbstractController
{
    /**
     * @Route("/", name="app_facturacion_index", methods={"GET"})
     */
    public function index(FacturasRepository $facturasRepository): Response
    {
        return $this->render('facturacion/index.html.twig', [
            'facturas' => $facturasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_facturacion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FacturasRepository $facturasRepository): Response
    {
        $factura = new Facturas();
        $form = $this->createForm(FacturacionType::class, $factura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facturasRepository->add($factura, true);

            return $this->redirectToRoute('app_facturacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facturacion/new.html.twig', [
            'factura' => $factura,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_facturacion_show", methods={"GET"})
     */
    public function show(Facturas $factura): Response
    {
        return $this->render('facturacion/show.html.twig', [
            'factura' => $factura,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_facturacion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Facturas $factura, FacturasRepository $facturasRepository): Response
    {
        $form = $this->createForm(FacturacionType::class, $factura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facturasRepository->add($factura, true);

            return $this->redirectToRoute('app_facturacion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facturacion/edit.html.twig', [
            'factura' => $factura,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_facturacion_delete", methods={"POST"})
     */
    public function delete(Request $request, Facturas $factura, FacturasRepository $facturasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$factura->getId(), $request->request->get('_token'))) {
            $facturasRepository->remove($factura, true);
        }

        return $this->redirectToRoute('app_facturacion_index', [], Response::HTTP_SEE_OTHER);
    }
}
