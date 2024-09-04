<?php

namespace App\DataFixtures;

use App\Entity\BienImmo;
use App\Entity\City;
use App\Entity\PropertyType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ){}
    private const NB_BIENIMMO = 50;
    private const PROPERTY_TYPE = ['Appartement', 'Maison'];
    public function load(ObjectManager $manager): void
    {
/*------------------ PropertyType --------------------------*/
        $propertyTypes = [];

        foreach(self::PROPERTY_TYPE as $type){
            $propertyName = new PropertyType();
            $propertyName->setName($type);
            $propertyTypes[] = $propertyName;

            $manager->persist($propertyName);
        }
/*------------------- City -------------------------------*/

        $faker = Factory::create('fr_FR');
        $cities = [];
        for($i = 0; $i <= 10; $i++){
            $city = new City();
            $city
                ->setName($faker->city)
                ->setPostalCode($faker->postcode);
            $cities[] = $city;

            $manager->persist($city);
        }
/*-------------------- Bien Immo ----------------------------*/

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
/*------------------ Users -----------------------*/
        $admin = new User();
        $admin
            ->setEmail("admin@immo.fr")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->hasher->hashPassword($admin, "admin1234"));

        $manager->persist($admin);

        $regularUser = new User();
        $regularUser
            ->setEmail("regular@immo.fr")
            ->setPassword($this->hasher->hashPassword($regularUser, "regular1234"));
        
        $manager->persist($regularUser);

        $manager->flush();
    }
}
