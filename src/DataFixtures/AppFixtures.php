<?php

namespace App\DataFixtures;

use App\Entity\BienImmo;
use App\Entity\City;
use App\Entity\PropertyType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_BIENIMMO = 50;
    private const PROPERTY_TYPE = ['Appartement', 'Maison'];
    public function load(ObjectManager $manager): void
    {
        $propertyTypes = [];

        foreach(self::PROPERTY_TYPE as $type){
            $propertyName = new PropertyType();
            $propertyName->setName($type);
            $propertyTypes[] = $propertyName;

            $manager->persist($propertyName);
        }

        $faker = Factory::create('fr_FR');
        $cities = [];
        for($i = 0; $i <= 10; $i++){
            $city = new City();
            $city->setName($faker->city);
            $cities[] = $city;

            $manager->persist($city);
        }

        $faker = Factory::create('fr_FR');
        $realEstate = [];
        for($i = 0; $i <= self::NB_BIENIMMO; $i++){
            $realEstate = new BienImmo();
            $realEstate
                    ->setPropertyType($faker->randomElement($propertyTypes))
                    ->setTitle($faker->realTextBetween(10, 50))
                    ->setContent($faker->realTextBetween(100, 200))
                    ->setAddress($faker->streetAddress)
                    ->setCity($faker->randomElement($cities))
                    ->setPostalCode($faker->postcode)
                    ->setSurface($faker->randomFloat)
                    ->setNbRooms($faker->numberBetween(1, 8))
                    ->setNbBedrooms($faker->numberBetween(1, 3))
                    ->setPrice($faker->numberBetween(400000, 5000000))
                    ->setYearOfConstruction($faker->year)
                    ->setElevator($faker->boolean(33))
                    ->setBalcony($faker->boolean(33))
                    ->setGarden($faker->boolean(65))
                    ->setSwimmingPool($faker->boolean(33))
                    ->setParking($faker->boolean(70))
                    ->setPublicationDate($faker->dateTimeThisDecade)
                    ->setReference($faker->bothify('??-####'));
            
            $manager->persist($realEstate);
        }

        $manager->flush();
    }
}
