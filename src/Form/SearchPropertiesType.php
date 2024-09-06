<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\PropertyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('propertyType', EntityType::class, [
                'class' => PropertyType::class,
                'choice_label' => 'name', // Ici est définis quel champ de l'entté doit être affiché pour les options du menu déroulant
                'required' => false,
                'placeholder' => 'Choisir un type de bien',
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Choisir une ville',
            ])
            ->add('nbRooms', ChoiceType::class, [
                'choices' => [
                    '1 pièce' => 1,
                    '2 pièces' => 2,
                    '3 pièces' => 3,
                    '4 pièces' => 4,
                    '5 pièces' => 5,
                    '6 pièces' => 6,
                    '7 pièces' => 7,
                    '8 pièces' => 8,
                ],
                'required' => false,
                'placeholder' => 'Choisir le nombre de pièces',
                'label' => 'Nombre de pièces',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
        ]);
    }
}
