<?php
namespace App\Controller;

use App\Repository\ReservaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminReservaController extends AbstractController
{
    #[Route('/admin/reserva', name: 'app_admin_reserva')]
    public function index(ReservaRepository $reservaRepository): Response
    {
        $reservas = $reservaRepository->findAll();

        return $this->render('admin_reserva/index.html.twig', [
            'controller_name' => 'AdminReservaController',
            'reservas'        => $reservas,
        ]);
    }

    
}
