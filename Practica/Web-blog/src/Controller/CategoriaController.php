<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Form\CategoriaType;
use App\Repository\CategoriasRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    /**
     * @Route("/categoria", name="app_categoria")
     */
    public function index(Request $request, CategoriasRepository $cateRepo): Response
    {

        $categoria = new Categorias();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $categoria = $form->getData();
            $cateRepo->add($categoria, true);
            $this->addFlash("notice","Categoria ingresa con éxito");
            return $this->redirectToRoute('app_admin_dash_board');
                      
        }
        return $this->render('categoria/index.html.twig', [
            'formulario' => $form->createView(),
        ]);
    }
}
