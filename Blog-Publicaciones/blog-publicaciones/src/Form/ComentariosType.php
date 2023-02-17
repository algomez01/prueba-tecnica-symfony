<?php

namespace App\Form;

use App\Entity\Comentarios;
use App\Entity\Publicaciones;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComentariosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            $builder
                ->add('body', TypeTextType::class)
                ->add('publicacion', EntityType::class, [
                    'class' => Publicaciones::class,
                    'choice_label' => 'titulo',
                    'mapped' => false // este campo no se mapea a la propiedad de la entidad Comentarios
                ])
                ->add('publicacion_titulo', TypeTextType::class, [
                    'disabled' => true,
                    'mapped' => false // este campo no se mapea a la propiedad de la entidad Comentarios
                ]);
        }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comentarios::class,
        ]);
    }
}
