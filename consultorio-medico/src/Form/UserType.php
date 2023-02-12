<?php

namespace App\Form;

use App\Entity\User;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Se añade choice para la seleccion del tipo de usuario y almacenar el rol correspondiente en base
        $builder
            ->add('nombres',TextType::class)
            ->add('apellidos',TextType::class)
            ->add('email',TextType::class)
            ->add('password',PasswordType::class)
            ->add('tipoUsuario', ChoiceType::class, [
                'choices' => [
                    'Paciente' => 'Paciente',
                    'Médico' => 'Medico',
                    'Cajero' => 'Cajero',
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
