<?php

namespace App\Form;

use App\Entity\Course;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('Nombre',TextType::class);
           
            if($options['accion']=='editJuego')
            {
                $builder
            ->add('estado', ChoiceType::class,array(
                'choices'=>array('En planificacion'=>'Enplanificacion',
                'Activo'=>'Activo',
                'Inactivo'=>'Inactivo',
            )
            ))
            #->add('UserID',NumberType::class)
        ;
    }
    $builder
        ->add('save',SubmitType::class,['label'=>'Guardar']);
}
      

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
            'accion' => 'CrearCurso',
        ]);
    }
}
