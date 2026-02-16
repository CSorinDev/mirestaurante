<?php
namespace App\Form;

use App\Entity\Reserva;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'label'  => 'Fecha',
                'attr'   => [
                    'min' => (new \DateTime())->modify('+1 day')->format('Y-m-d'),
                ],
            ])
            ->add('hora', ChoiceType::class, [
                'choices' => [
                    'Comida (14:00 - 16:00)' => [
                        '14:00' => new \DateTime('14:00'),
                        '14:30' => new \DateTime('14:30'),
                        '15:00' => new \DateTime('15:00'),
                        '15:30' => new \DateTime('15:30'),
                    ],
                    'Cena (20:00 - 22:00)'   => [
                        '20:00' => new \DateTime('20:00'),
                        '20:30' => new \DateTime('20:30'),
                        '21:00' => new \DateTime('21:00'),
                        '21:30' => new \DateTime('21:30'),
                    ],
                ],
            ])
            ->add('comensales', ChoiceType::class, [
                'label' => 'Comensales',
                'choices' => [
                    "1" => 1,
                    "2" => 2,
                    "3" => 3,
                    "4" => 4,
                    "5" => 5,
                    "6" => 6,
                    "7" => 7,
                    "8" => 8,
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Reservar',
                "attr"  => ["class" => "btn"],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reserva::class,
        ]);
    }
}
