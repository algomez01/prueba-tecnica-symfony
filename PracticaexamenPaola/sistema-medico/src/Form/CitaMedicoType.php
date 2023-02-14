<?php

namespace App\Form;

use App\Entity\Cita;
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
            ->add('fecha_creacion',DateTimeType::class,["widget"=>"single_text", "disabled"=>true])
            ->add('descripcion',TextType::class,["disabled"=>true])
            ->add('estado',TextType::class,["disabled"=>true])
            ->add('tipoCita',ChoiceType::class,
                [
                    'choices' => $options["arrayTipoCita"], //array que se envia desde el controller
                    'choice_value'=>'id', //arributo de la entidad
                    'choice_label'=>'descripcion', //atributo de la entidad
                    'label'=>'Tipo de Cita', //lo que se muestra en pantalla
                    'mapped' => false //debido a que no hay relacion entre las entidades, enviamos bandera para que no se mapee
                ])
        ;
                }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cita::class,
            'arrayTipoCita' => array(), //valor por defecto en array
        ]);
    }
}
