<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CartaController extends AbstractController
{
    #[Route('/carta', name: 'app_carta')]
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        $categorias = $categoriaRepository->findAll();
        return $this->render('carta/index.html.twig', [
            'controller_name' => 'CartaController',
            'categorias' => $categorias
        ]);
    }
}
