<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nombre",
                'attr' => ['autofocus' => true],
            ])
            ->add("phone", TelType::class, [
                "label" => "Teléfono"
            ])
            ->add("date_time", DateTimeType::class, [
                "label" => "Fecha y Hora",
                "attr" => [
                    "min" => (new \DateTime())->format("Y-m-d\TH:i" ),
                    "max" => (new \DateTime("+1 month"))->format("Y-m-d\TH:i" )
                ]
            ])
            ->add("guests", IntegerType::class, [
                "label" => "Número de Comensales",
                "attr" => [
                    "min" => 1,
                    "step" => 1,
                    "max" => 12,
                    "value" => 2
                ]
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "RESERVAR"
            ])
        ;
    }
}
