<?php

namespace App\Form;

use App\Entity\BienImmo;
use App\Entity\City;
use App\Entity\PropertyType;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BienImmoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,[
                'label' => 'Accroche de l\'annonce'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description complète du bien immobilier'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('surface', NumberType::class, [
                'label' => 'Surface en m²'
            ])
            ->add('nbRooms', NumberType::class, [
                'label' => 'Nombre de pièce(s) total'
            ])
            ->add('nbBedrooms', NumberType::class, [
                'label' => 'Nombre de chambre(s)'
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix en euros'
            ])
            ->add('yearOfConstruction', NumberType::class, [
                'label' => 'Année de construction'
            ])
            ->add('elevator', ChoiceType::class, [
                'label' => 'Ascenceur',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('balcony', ChoiceType::class, [
                'label' => 'Balcon',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('garden', ChoiceType::class, [
                'label' => 'Jardin',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('swimmingPool', ChoiceType::class, [
                'label' => 'Piscine',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('parking', ChoiceType::class, [
                'label' => 'Place de parking',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true,
                'multiple' => false
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
            ->add('propertyType', EntityType::class, [
                'class' => PropertyType::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BienImmo::class,
        ]);
    }
}
