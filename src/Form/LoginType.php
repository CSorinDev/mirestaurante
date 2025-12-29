<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $firstLetter = "/^[a-zA-Z]/";
        $minLength6  = "/.{6,}/";
        $lastChar    = "/[a-zA-Z0-9]$/";

        $builder
            ->add('username', TextType::class, [
                "label"       => "Nombre de usuario",
                "attr"        => ["autofocus" => "focus"],
                "constraints" => [
                    new Regex($firstLetter, "Debe empezar por una letra"),
                    new Regex($minLength6, "Debe tener mínimo 6 caracteres"),
                    new Regex($lastChar, "Debe acabar con una letra o un dígito"),
                ],
            ])
            ->add("password", PasswordType::class, [
                "label" => "Contraseña",
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "Iniciar sesión",
            ])
        ;
    }
}
