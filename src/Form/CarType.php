<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Car;
use App\Entity\Energy;
use App\Entity\Image;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'model',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control"
                    ]
                ]
            )
            ->add(
                'gear',
                CheckboxType::class,
                [
                    "attr" => [
                        "class" => "form-check-input"
                    ]
                ]
            )
            ->add(
                'energy',
                EntityType::class,
                [
                    "class" => Energy::class,

                ]

            )
            ->add(
                'brand',
                EntityType::class,
                [
                    "class" => Brand::class,
                    "expanded" => true,
                    "multiple" => false
                ]
            )
            ->add(
                'image',
                FileType::class,
                [

                    "mapped" => false,
                    "required" => false,
                    "multiple" => true,
                ]
            )
            ->add(
                'save',
                SubmitType::class,
                [
                    "attr" => [
                        "class" => "btn btn-primary mt-5"
                    ]
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Car::class,


            ]
        );
    }
}
