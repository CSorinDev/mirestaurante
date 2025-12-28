<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                "label" => "Usuario"
            ])
            ->add("name", TextType::class, [
                "label" => "Nombre"
            ])
            ->add("email", EmailType::class, [
                "label" => "Correo"
            ])
            ->add("phone", TelType::class, [
                "label" => "Teléfono"
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "Registro"
            ])
        ;
    }
}
