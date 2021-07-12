<?php


namespace App\DataFixtures;


use App\Entity\Energy;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EnergyFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $energys = ["gas", "electric", "hybrid", "diesel", "hydrogen"];

        foreach ($energys as $energyString) {
            $object = new Energy();
            $object->setType($energyString);
            $manager->persist($object);

            $this->addReference($energyString,$object);
            $manager->persist($object);
        }
        $manager->flush();
    }

}