<?php

namespace App\Form;

use App\Entity\Capacitaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CapacitacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('descripcion')
            ->add('user_id')
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'En Planificación' => 'EnPlanificacion',
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Capacitaciones::class,
        ]);
    }
}
