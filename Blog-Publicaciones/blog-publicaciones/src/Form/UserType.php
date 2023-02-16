<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class)
           # ->add('roles')
            ->add('password',PasswordType::class)
            ->add('nombres',TextType::class)
            ->add('apellidos',TextType::class)
            #->add('fe_creacion',DateTimeType::class,["widget"=>"single_text", "disabled"=>true])
            ->add('TipoUsuario', ChoiceType::class, [
                'choices' => [
                    'Usuario' => 'Usuario',
                    'Trabajador' => 'Trabajador',
                    'Supervisor' => 'Supervisor',
                    'Admin' => 'Admin',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
