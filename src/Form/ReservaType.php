<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'       => "Nombre",
                'attr'        => ['autofocus' => true],
                "constraints" => [
                    new NotBlank(message: "El nombre es obligatorio"),
                    new Length(min: 3, minMessage: "El nombre tiene que tener mínimo 3 caracteres"),
                    new Regex(pattern: "/^[a-zA-ZáéíóúÁÉÍÓÚàèìòùÀÈÌÒÙ]$/", message: "El nombre no puede contener símbolos ni números"),
                ],
            ])
            ->add("phone", TelType::class, [
                "label"       => "Teléfono",
                "constraints" => [
                    new Regex(pattern: "/^[6-7][0-9]{8}/", message: "Introduzca un número de teléfono móvil válido"),
                ],
            ])
            ->add("date_time", DateTimeType::class, [
                "label"       => "Fecha y Hora",
                "widget"      => "single_text",
                "attr"        => [
                    "min" => (new \DateTime())->format("Y-m-d\TH:i"),
                    "max" => (new \DateTime("+1 month"))->format("Y-m-d\TH:i"),
                ],
                "constraints" => [
                    new GreaterThan(value: "today", message: "La reserva de ser para un fecha futura"),
                ],
            ])
            ->add("guests", IntegerType::class, [
                "label"       => "Número de Comensales",
                "attr"        => [
                    "min"   => 2,
                    "max"   => 8,
                    "step"  => 1,
                    "value" => 2,
                ],
                "constraints" => [new Range(min: 2, max: 8, notInRangeMessage: "Reservas de 2 a 8 personas")],
            ])
            ->add("submit_button", SubmitType::class, [
                "label" => "RESERVAR",
            ])
        ;
    }
}
