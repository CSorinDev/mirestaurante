<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TerminosController extends AbstractController
{
    #[Route('/terminos-y-condiciones', name: 'app_terminos')]
    public function index(): Response
    {
        return $this->render('terminos/index.html.twig', [
            'controller_name' => 'TerminosController',
        ]);
    }
}
