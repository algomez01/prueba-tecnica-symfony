<?php

namespace App\Form;

use App\Entity\Curso;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class CursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NombreCurso',TextType::class);
           
            if($options['accion']=='editCurso')
            {
                $builder
            ->add('Estado', ChoiceType::class,array(
                'choices'=>array(
                'Activo'=>'Activo',
                'Inactivo'=>'Inactivo',
                )
                ))
               
            ;
        }
        $builder
            ->add('save',SubmitType::class,['label'=>'Guardar']);
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Curso::class,
            'accion' => 'CrearCurso',
        ]);
    }
}
