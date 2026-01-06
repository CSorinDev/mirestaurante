<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                "label"       => "Usuario",
                "attr"        => ["autofocus" => "focus"],
                "constraints" => [
                    new NotBlank(message: "El usuario es obligatorio"),
                    new Length(min: 6, minMessage: "El usuario debe tener mínimo 6 caracteres"),
                    new Regex(pattern: "/[a-zA-Z0-9]/$", message: "El usuario debe acabar en una letra o en un dígito"),
                ],
            ])
            ->add("name", TextType::class, [
                "label"       => "Nombre y Apellidos",
                "constraints" => [
                    new NotBlank(message: "El nombre completo es obligatorio"),
                    new Length(min: 6, minMessage: "El nombre completo debe tener al menos 6 caracteres"),
                ],
            ])
            ->add("email", EmailType::class, [
                "label"       => "Correo",
                "constraints" => [
                    new NotBlank(message: "El email es obligatorio"),
                    new Regex(
                        pattern: "/^[a-zA-Z].{5,}@[a-zA-Z0-9]{3,}\.[a-zA-Z]{2-3}$/",
                        message: "El formato del correo no es correcto"
                    ),
                ],
            ])
            ->add("phone", TelType::class, [
                "label"       => "Teléfono",
                "constraints" => [
                    new NotBlank(message: "El número de teléfono es obligatorio"),
                    new Regex(pattern: "/^[6-7][0-9]{8}$/", message: "Número de teléfono móvil inválido"),
                ],
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "Registro",
            ])
        ;
    }
}
