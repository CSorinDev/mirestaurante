<?php
namespace App\Form;

use App\Entity\Carta;
use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CartaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'required' => true
            ])
            ->add('descripcion')
            ->add('precio', NumberType::class, [
                'required' => true
            ])
            ->add('foto_archivo', FileType::class, [
                'label'       => "Imagen del producto (jpg o png)",
                'mapped'      => false,
                'required'    => false,
                'constraints' => [
                    new File(
                        maxSize: '2M',
                        mimeTypes: [
                            'image/jpeg',
                            'image/png',
                        ],
                        mimeTypesMessage: 'Por favor, sube una imagen válida (JPG o PNG)'
                    ),
                ],
            ])
            ->add('categoria', EntityType::class, [
                'class'        => Categoria::class,
                'choice_label' => 'nombre',
                'placeholder' => "Selecciona una categoría",
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                "label" => 'Guardar',
                "attr"  => ["class" => "btn"],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carta::class,
        ]);
    }
}
