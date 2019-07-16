<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("firstName", TextType::class, [
                'label' => 'Votre nom:',
                'required' => true,
            ])
            ->add("lastName", TextType::class, [
                'label' => 'Votre prenom:',
                'required' => true,
            ])
            ->add("showPlace", TextType::class, [
                'label' => 'Lieux du spectacle:',
                'required' => true,
            ])
            ->add("age1", CheckboxType::class, [
                'label' => '-12 ans',
                'required'   => false,
            ])
            ->add("age2", CheckboxType::class, [
                'label' => 'Entre 12 et 16 ans',
                'required'   => false,
            ])
            ->add("age3", CheckboxType::class, [
                'label' => 'Plus de 16 ans',
                'required'   => false,
            ])
            ->add("showDate", DateType::class, [
                'label' => 'Date du spectacle:',
                'required'   => false,
            ])
            ->add("email", EmailType::class, [
                'label' => 'Votre e-mail:',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
