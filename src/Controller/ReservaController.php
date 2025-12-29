<?php
namespace App\Controller;

use App\Form\ReservaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservaController extends AbstractController
{

    #[Route("/reserva", name: "reserva")]
    public function reserva(Request $request): Response
    {
        $reservaForm = $this->createForm(ReservaType::class);
        $reservaForm->handleRequest($request);

        if ($reservaForm->isSubmitted() && $reservaForm->isValid()) {
            // handle Reserva
        }

        return $this->render("default/reserva.html.twig", [
            'controller_name' => 'DefaultController',
            "reserva_form"    => $reservaForm->createView(), // Recuerda usar createView()
        ]);
    }

}
