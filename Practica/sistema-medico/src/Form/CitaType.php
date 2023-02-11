<?php

namespace App\Form;
use App\Entity\Cita;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('TipoCita',TextType::class)
        ->add('Duracion',TextType::class);
        $builder->add('Fecha', DateType::class, [
            // ...
            'years' => range(2023, 2027),
            'months' => range(1, 12),
            'days' => range(1, 31),
        ]);
       
        $builder 
        ->add('save',SubmitType::class,['label'=>'Guardar']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cita::class,
            'accion' => 'CrearCurso',
        ]);
    }
}
