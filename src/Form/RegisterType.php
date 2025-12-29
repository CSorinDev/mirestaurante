<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $firstLetter           = "/^[a-zA-Z]/";
        $minLength6            = "/.{6,}/";
        $doubleSpaceNotAllowed = "/^(?!.* {2,}).*$/";
        $lastChar              = "/[a-zA-Z0-9]$/";
        $emailFormat           = "/.{6,}@.{3,}\..{2,3}/";
        $phoneFirstDigit       = "/^[6-7]/";
        $has9Digits            = "/^[0-9]{9}$/";

        $builder
            ->add('username', TextType::class, [
                "label"       => "Usuario",
                "attr"        => ["autofocus" => "focus"],
                "constraints" => [
                    new Regex($firstLetter, "Debe empezar por una letra"),
                    new Regex($minLength6, "Debe tener mínimo 6 caracteres"),
                    new Regex($lastChar, "Debe acabar en una letra o un dígito"),
                ],
            ])
            ->add("name", TextType::class, [
                "label"       => "Nombre y Apellidos",
                "constraints" => [
                    new Regex($firstLetter, "Debe empezar por una letra"),
                    new Regex($minLength6, "Debe tener mínimo 6 caracteres"),
                    new Regex($doubleSpaceNotAllowed, "No puede tener 2 espacios seguidos"),
                ],
            ])
            ->add("email", EmailType::class, [
                "label"       => "Correo",
                "constraints" => [
                    new Regex($firstLetter, "Debe empezar por una letra"),
                    new Regex($emailFormat, "Formato de email incorrecto"),
                ],
            ])
            ->add("phone", TelType::class, [
                "label"       => "Teléfono",
                "constraints" => [
                    new Regex($phoneFirstDigit, "Debe empezar por 6 o por 7"),
                    new Regex($has9Digits, "Debe tener 9 dígitos"),
                ],
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "Registro",
            ])
        ;
    }
}
