<?php

namespace App\Form;

use App\Entity\Reserva;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
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
                'label' => 'Fecha de la reserva',
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d'),
                ]
            ])
            ->add('hora', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Hora',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Reservar',
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