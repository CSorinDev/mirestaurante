<?php
namespace App\Controller;

use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route("/register", name: "register")]
    public function register(Request $request): Response
    {
        $registerForm = $this->createForm(RegisterType::class);
        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            // handle register
        }

        return $this->render("default/register.html.twig", [
            "register_form" => $registerForm,
        ]);
    }
}
