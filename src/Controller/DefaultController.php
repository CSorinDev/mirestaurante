<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ReservaType;

final class DefaultController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route("/carta", name: "carta")]
    public function carta(): Response {
        return $this->render("default/carta.html.twig", [
            'controller_name' => 'DefaultController'
        ]);
    }

    #[Route("/reserva", name: "reserva")]
    public function reserva(): Response {
        $reservaForm = $this->createForm(ReservaType::class);
        return $this->render("default/reserva.html.twig", [
            'controller_name' => 'DefaultController',
            "reserva_form" => $reservaForm
        ]);
    }

    #[Route("/login", name:"login")]
    public function login(): Response {
        $loginForm = $this->createForm(LoginType::class);
        return $this->render('default/login.html.twig', [
            'controller_name' => 'DefaultController',
            "login_form" => $loginForm
        ]);
    }

    #[Route("/register", name:"register")]
    public function register(): Response {
        $registerForm = $this->createForm(RegisterType::class);
        return $this->render("default/register.html.twig", [
            "register_form" => $registerForm
        ]);
    }

}
