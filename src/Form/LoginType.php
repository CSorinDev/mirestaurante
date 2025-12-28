<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                "label" => "Nombre de usuario"
            ])
            ->add("password", PasswordType::class, [
                "label" => "Contraseña"
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "Iniciar sesión"
            ])
        ;
    }
}
