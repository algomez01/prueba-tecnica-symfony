<?php

namespace App\Form;

use App\Entity\Citas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Citas1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fecha_creacion')
            ->add('motivo')
            ->add('estado')
            ->add('pacienteId')
            ->add('medicoId')
            ->add('tipoCitaId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citas::class,
        ]);
    }
}
