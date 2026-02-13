<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Form\ReservaType;
use App\Repository\ReservaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservaController extends AbstractController
{
    #[Route('/reserva', name: 'app_reserva')]
    public function index(Request $request, EntityManagerInterface $em, ReservaRepository $reservaRepository): Response
    {
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $reserva = new Reserva();
        $form = $this->createForm(ReservaType::class, $reserva);
        $form->handleRequest($request);

        $reservas = $reservaRepository->findBy(
            ['user' => $this->getUser()],
            ['fecha' => "desc", "hora" => "desc"]
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $reserva->setUser($this->getUser());
            
            $em->persist($reserva);
            $em->flush();

            $this->addFlash('success', '¡Reserva realizada con éxito!');

            return $this->redirectToRoute('app_my_profile');
        }

        return $this->render('reserva/index.html.twig', [
            'form' => $form,
            'reservas' => $reservas
        ]);
    }

    #[Route(path: "/misreservas", name: "app_mis_reservas")]
    public function misReservas(ReservaRepository $reservaRepository) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $reservas = $reservaRepository->findBy(
            ['user' => $this->getUser()],
            ['fecha' => "desc", "hora" => "desc"]
        );

        return $this->render('reserva/mis_reservas.html.twig',[
            'reservas' => $reservas
        ]);
    }
}