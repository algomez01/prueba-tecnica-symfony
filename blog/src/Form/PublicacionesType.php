<?php

namespace App\Form;

use App\Entity\Publicaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo',TextType::class)
            ->add('descripcion',TextType::class)
           
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                    
                ]
            ])
            ->add('Categoria',ChoiceType::class,
            [
                'choices' => $options["arrayTipocategoria"], //array que se envia desde el controller
                'choice_value'=>'id', //arributo de la entidad
                'choice_label'=>'nombre', //atributo de la entidad
                'label'=>'Tipo de categoria', //lo que se muestra en pantalla
                'mapped' => false //debido a que no hay relacion entre las entidades, enviamos bandera para que no se mapee
            ])        
        ;
        
        
    }
            
    

           

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publicaciones::class,
            'arrayTipocategoria' => array(),
        ]);
    }
}
