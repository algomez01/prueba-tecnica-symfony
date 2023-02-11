<?php

namespace App\Form;

use App\Entity\Citas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha')
            ->add('hora');
            if($options['accion']=='editCitas')
            {

                $builder
                ->add('duracion')
            ->add('TipoCita', ChoiceType::class,array(
                'choices'=>array('EnAsignacion'=>'EnAsignacion',
                'general'=>'general',
                'odontologico'=>'odontologico',
               
            )
            
            ))
            
            ->add('userId')
        ;
    }
    $builder
    ->add('save',SubmitType::class,['label'=>'Guardar']);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citas::class,
            'accion' => 'CrearCitas'
        ]);
    }
}
