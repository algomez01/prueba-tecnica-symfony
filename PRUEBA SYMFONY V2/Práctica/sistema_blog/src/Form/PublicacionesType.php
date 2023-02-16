<?php

namespace App\Form;

use App\Entity\Publicaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Se crear choice para 
        $builder
            ->add('titulo')
            ->add('descripcion')
            ->add('categoria', ChoiceType::class, [
                'choices' => [
                    'Tecnología' => 'Tecnología',
                    'Ciencias' => 'Ciencias',
                    'Entretenimiento' => 'Entretenimiento',
                ]
            ])
            #->add('Guardar', SubmitType::class, ['label' => 'Publicar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publicaciones::class,
        ]);
    }
}
