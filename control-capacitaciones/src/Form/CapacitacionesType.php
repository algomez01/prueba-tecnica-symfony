<?php

namespace App\Form;

use App\Entity\Capacitaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CapacitacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', TextType::class)
            ->add('descripcion', TextType::class)
            #->add('user_id')
        ;
        
        if($options['accion'] == 'editCapacitacion')
        {
            $builder->add('estado', ChoiceType::class,array(
                         'choices'=>array(
                         'En planificación'=> 'EnPlanificacion',
                         'Activo'=>'Activo',
                         'Inactivo'=>'Inactivo',
                        )
                        ))
            ;

        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Capacitaciones::class,
            'accion' => 'newCapacitacion'
        ]);
    }
}
