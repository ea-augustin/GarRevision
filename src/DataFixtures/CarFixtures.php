<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cars = [
            [
                "model" => "Model S",
                "gear" => true,
                "brand" => "tesla",
                "energy" => "electric",
                "images" => [
                    "tesla-1",
                    "tesla-2",
                    "tesla-3"
                ]
            ],
            [
                "model" => "clio",
                "gear" => true,
                "brand" => "renault",
                "energy" => "diesel",
                "images" => [
                    "clio-1",
                    "clio-2",
                ]
            ],
            [
                "model" => "civic",
                "gear" => false,
                "brand" => "honda",
                "energy" => "gas",
                "images" => [
                    "civic-1",
                ]
            ],
            [
                "model" => "six",
                "gear" => false,
                "brand" => "mazda",
                "energy" => "hybrid",
                "images" => [
                    "six-1",
                ]
            ]
        ];

        foreach ($cars as $car){
            $object = new Car();
            $object->setGear($car['gear']);
            $object->setModel($car['model']);
            $object->setBrand($this->getReference($car["brand"]));
            $object->setEnergy($this->getReference($car["energy"]));

            foreach ($car['images'] as $image){
               $object->addImage($this->getReference($image));
            }


            $manager->persist($object);
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BrandFixture::class,
            EnergyFixtures::class,
            ImageFixtures::class
        ];
    }
}
