<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                "attr"        => ["autofocus" => "focus"],
                "label"       => "Nombre de usuario",
                "constraints" => [
                    new NotBlank(message: "El usuario es obligatorio"),
                    new Length(min: 6, minMessage: "Nombre de usuario incorrecto"),
                    new Regex(pattern: "/[a-zA-Z0-9]$/", message: "Nombre de usuario incorrecto"),
                ],
            ])
            ->add("password", PasswordType::class, [
                "label"       => "Contraseña",
                "constraints" => [new Length(min: 6, minMessage: "Contraseña incorrecta")],
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "Iniciar sesión",
            ])
        ;
    }
}
