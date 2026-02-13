<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Form\ReservaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservaController extends AbstractController
{
    #[Route('/reserva', name: 'app_reserva')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // Verificar que el usuario está autenticado
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $reserva = new Reserva();
        $form = $this->createForm(ReservaType::class, $reserva);
        $form->handleRequest($request);

        // Solo guardar si el formulario fue enviado Y es válido
        if ($form->isSubmitted() && $form->isValid()) {
            // Asignar el usuario actual a la reserva
            $reserva->setUser($this->getUser());
            
            $em->persist($reserva);
            $em->flush();

            // Mensaje de éxito
            $this->addFlash('success', '¡Reserva realizada con éxito!');

            // Redirigir para evitar reenvío del formulario
            return $this->redirectToRoute('app_my_profile');
        }

        return $this->render('reserva/index.html.twig', [
            'form' => $form,
        ]);
    }
}