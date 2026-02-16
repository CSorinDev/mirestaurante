<?php
namespace App\Controller;

use App\Entity\Reserva;
use App\Repository\ReservaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminReservaController extends AbstractController
{
    #[Route('/admin/reserva', name: 'app_admin_reserva')]
    public function index(ReservaRepository $reservaRepository): Response
    {
        $reservas = $reservaRepository->findAll();
        // dd($reservas);

        return $this->render('admin_reserva/index.html.twig', [
            'controller_name' => 'AdminReservaController',
            'reservas'        => $reservas,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_reserva_delete', methods: ['POST'])]
    public function delete(Request $request, Reserva $reserva, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reserva->getId(), $request->getPayload()->getString('_token'))) {
            $fecha = $reserva->getFecha()->format('d/m/Y');
            $hora  = $reserva->getHora()->format('H:i');

            $entityManager->remove($reserva);
            $entityManager->flush();

            $this->addFlash(
                'success',
                message: 'Tu reserva del día ' . $fecha . ' a la hora ' . $hora . ' ha sido cancelada');
        }

        return $this->redirectToRoute('app_mis_reservas', [], Response::HTTP_SEE_OTHER);
    }
}
