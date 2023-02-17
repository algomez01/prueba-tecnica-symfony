<?php

namespace App\Form;

use App\Entity\Publicaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Se crear choice para 
        $builder
            ->add('titulo', TextType::class)
            ->add('descripcion', TextType::class)
            ->add('categoria', ChoiceType::class, [
                    'choices' => $options["arrayCategorias"], //array que se envia desde el controller
                    'choice_value'=>'id', //arributo de la entidad
                    'choice_label'=>'descripcion', //atributo de la entidad
                    'label'=>'Categoria', //lo que se muestra en pantalla
                    'mapped' => false //debido a que no hay relacion entre las entidades, enviamos bandera para que no se mapee
            ])
            #->add('Guardar', SubmitType::class, ['label' => 'Publicar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publicaciones::class,
            'arrayCategorias' => array(), //se crea el array para enviarlo al form
        ]);
    }
}
