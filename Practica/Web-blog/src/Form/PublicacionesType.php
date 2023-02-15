<?php

namespace App\Form;

use App\Entity\Publicaciones;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('cuerpo')
            ->add('estado')
            #->add('user_id')
            ->add('categoria_id', ChoiceType::class, [
                'choices' => [
                'Documentales' => 'Documentales',
                'juegos' => 'juegos',
                'Suspenso' => 'Suspenso',
               ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publicaciones::class,
        ]);
    }
}
