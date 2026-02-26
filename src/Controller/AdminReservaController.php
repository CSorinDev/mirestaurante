<?php
namespace App\Controller;

use App\Entity\Reserva;
use App\Repository\ReservaRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/admin/reserva/{id}/confirmar', name: 'app_admin_reserva_confirmar')]
    public function confirmar(Reserva $reserva, EntityManagerInterface $em): Response
    {
        $reserva->setConfirmada(true);
        $em->flush();

        return $this->redirectToRoute('app_admin_reserva');
    }
}
