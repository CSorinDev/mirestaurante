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

    #[Route('/admin/reserva/delete-old', name: 'app_admin_reserva_delete_old')]
    public function eliminar(ReservaRepository $reservaRepository, EntityManagerInterface $em): Response
    {
        $encontradas = false;
        $reservas    = $reservaRepository->findAll();

        foreach ($reservas as $reserva) {
            if ($reserva->getFecha() < new \DateTime()) {
                $encontradas = true;
                $em->remove($reserva);
            }
        }
        
        if (! $encontradas) {
            $this->addFlash('info', 'No se encontraron reservas antiguas para eliminar.');
        } else {
            $this->addFlash('success', 'Reservas antiguas eliminadas correctamente.');


        }
        $em->flush();

        return $this->redirectToRoute('app_admin_reserva');
    }
}
