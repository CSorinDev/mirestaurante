<?php
namespace App\Controller;

use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    #[Route("/login", name: "login")]
    public function login(Request $request): Response
    {
        $loginForm = $this->createForm(LoginType::class);
        $loginForm->handleRequest($request);

        if ($loginForm->isSubmitted() && $loginForm->isValid()) {
            // handle Login
        }

        return $this->render('default/login.html.twig', [
            "login_form"      => $loginForm->createView(),
        ]);
    }
}
