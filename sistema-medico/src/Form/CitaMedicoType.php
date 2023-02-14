<?php

namespace App\Form;

use App\Entity\Citas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitaMedicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fe_creacion',DateTimeType::class,["widget"=>"single_text", "disabled"=>true])
        ->add('motivo',TextType::class,["disabled"=>true])
        ->add('estado',TextType::class,["disabled"=>true])
        ->add('tipoCita',ChoiceType::class,
            [
                'choices' => $options["arrayTiposCitas"],
                'choice_value'=>'id', 
                'choice_label'=>'descripcion', 
                'label'=>'Tipo de Cita', 
                'mapped' => false 
            ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citas::class,
            'arrayTiposCitas' => array(),
        ]);
    }
}
