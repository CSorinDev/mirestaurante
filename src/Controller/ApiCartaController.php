<?php

namespace App\Controller;
use App\Repository\CartaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ApiCartaController extends AbstractController {
    #[Route("/api/carta", methods: ["GET"], name: "api_carta")]
    public function index(CartaRepository $cartaRepository): JsonResponse {
        $productos = $cartaRepository->findAll();

        $data = array_map(function($carta): array {
            return [
                'nombre' => $carta->getNombre(),
                'descripcion' => $carta->getDescripcion() ?? null,
                'imagen' => $carta->getImagen() ?? null,
                'precio' => $carta->getPrecio(),
                'categoria' => $carta->getCategoria()->getNombre()

            ];
        }, $productos);
        
    
        return new JsonResponse($data);
    }
}