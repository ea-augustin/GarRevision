<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use function Symfony\Component\String\b;

class BrandFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $brands = [
            "renault",
            "tesla",
            "honda",
            "mazda",
        ];

        foreach ($brands as $brand) {
            $object = new Brand();
            $object->setName($brand);
            $object->setLogo($this->getReference(strtolower($brand) . "-logo"));
            $manager->persist($object);

            $this->addReference(strtolower($brand), $object);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ImageFixtures::class
        ];
    }
}
