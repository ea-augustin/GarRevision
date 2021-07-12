<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $images = [
            [
                "brand" => "renault",
                "url" => "https://www.largus.fr/images/images/logo-renault-fond-noir.jpg",
                "alt" => "renault_image"
            ],
            [
                "brand" => "tesla",
                "url" => "https://ae01.alicdn.com/kf/Hd8de533db27e497db98f6e2a71351f5cj.jpg",
                "alt" => "tesla_image"
            ],
            [
                "brand" => "mazda",
                "url" => "https://logo-marque.com/wp-content/uploads/2020/05/Mazda-Logo.png",
                "alt" => "mazda_image"
            ],
            [
                "brand" => "honda",
                "url" => "https://cdn.1min30.com/wp-content/uploads/2017/09/Logo-Honda.jpg",
                "alt" => "honda_image"
            ],
        ];
        foreach ($images as $image) {
            $object = new Image();
            $object->setUrl($image["url"]);
            $object->setAlt($image["alt"]);
            $manager->persist($object);

            $this->addReference($image['brand'] . "-logo", $object);
        }

        $images = [
            [
                "reference" => "tesla-1",
                "url" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTzxZZv8NTHgU0bynlt7MhqSZI9ZlEhfKBddt6uBxscgXxnfaxugvIqN3-D9vKa5j_xRTc&usqp=CAU",
                "alt" => "tesla_image"

            ],
            [
                "reference" => "tesla-2",
                "url" => "https://www.elite-auto-actu.fr/wp-content/uploads/2020/10/CREDIT-TESLA-Une-voiture-sans-permis-au-lieu-d-une-supercar.jpg",
                "alt" => "tesla_image"

            ],
            [
                "reference" => "tesla-3",
                "url" => "https://www.auto-moto.com/wp-content/uploads/sites/9/2017/11/tesla-roadster-9-728x410.jpg",
                "alt" => "tesla_image"

            ],

            [
                "reference" => "clio-1",
                "url" => "https://img4.autodeclics.com/photo_article/83907/16127/1200-L-essai-renault-clio-5-titre-en-jeu.jpg",
                "alt" => "clio_image"

            ],
            [
                "reference" => "clio-2",
                "url" => "https://images.caradisiac.com/images/4/6/8/5/174685/S0-renault-clio-v-2019-la-nouvelle-star-en-direct-du-salon-de-geneve-2019-583205.jpg",
                "alt" => "clio_image"

            ],
            [
                "reference" => "civic-1",
                "url" => "https://i.gaw.to/content/photos/44/50/445018-internet-s-amuse-avec-la-future-honda-civic-2022.jpg",
                "alt" => "civic_image"

            ],
            [
                "reference" => "six-1",
                "url" => "https://fr.cdn.mazda.media/f3ee7c285ea84a67ab37652f6fb9e5c5/9200d579244a45a5b8476d1ab3d5d7e8.png?rnd=4a9d5d",
                "alt" => "six_image"

            ]

        ];
         foreach ($images as $image){
             $object= new Image();
             $object->setUrl($image["url"]);
             $object->setAlt($image["alt"]);
             $manager->persist($object);
             $this->addReference($image["reference"],$object);


         }

        $manager->flush();
    }
}
