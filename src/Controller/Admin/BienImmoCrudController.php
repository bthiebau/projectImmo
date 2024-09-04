<?php

namespace App\Controller\Admin;

use App\Entity\BienImmo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BienImmoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BienImmo::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('propertyType', 'Type de bien')->autocomplete(),
            IdField::new('id')->hideOnForm(),
            TextField::new('title', 'Accroche de l\'annonce'),
            TextEditorField::new('content', 'Description complète du bien'),
            TextField::new('address', 'Adresse'),
            AssociationField::new('city', 'Ville'),
            NumberField::new('surface', 'Surface en m²'),
            NumberField::new('nbRooms', 'Nombre de pièce(s) totale(s) (chambres incluses)'),
            NumberField::new('nbBedrooms', 'Nombre de chambre(s)'),
            NumberField::new('price', 'Prix en euro'),
            NumberField::new('yearOfConstruction', 'Année de construction'),
            BooleanField::new('elevator', 'Ascenceur'),
            BooleanField::new('balcony', 'Balcon'),
            BooleanField::new('garden', 'Jardin'),
            BooleanField::new('swimmingPool', 'Piscine'),
            BooleanField::new('parking', 'Place de parking'),
            DateField::new('publicationDate', 'Date de publication'),
            TextField::new('reference', 'référence')
        ];
    }
    
}
