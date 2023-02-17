<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class CategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Descripcion', TextType::class)
            ->add('categoria', ChoiceType::class, [
                    'choices' => $options["arrayCategorias"], //array que se envia desde el controller
                    'choice_value'=>'id', //arributo de la entidad
                    'choice_label'=>'descripcion', //atributo de la entidad
                    'label'=>'Categoria', //lo que se muestra en pantalla
                    'mapped' => false //debido a que no hay relacion entre las entidades, enviamos bandera para que no se mapee
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categoria::class,
        ]);
    }
}
