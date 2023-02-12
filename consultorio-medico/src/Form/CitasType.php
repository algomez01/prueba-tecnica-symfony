<?php

namespace App\Form;

use App\Entity\Citas;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CitasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            #->add('fe_creacion') //se setea por debajo con la fecha actual del sistema
            ->add('motivo')
            #->add('estado') //seta por debajo el estado inicial de la cita
            #->add('tipoCitaId') el tipo lo llena el médico según el ejercicio
            #->add('pacienteId') paciente es el usuario logueado
            #->add('medicoId') será el médico que tome la  cita médica
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Citas::class,
        ]);
    }
}
