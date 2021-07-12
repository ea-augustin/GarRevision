<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    "attr" => [
                        "class" => "form-control"
                    ]
                ]
            )
            ->add(
                'url',
                TextType::class,

                [
                    "required" =>false,

                    "attr" => [
                        "class" => "form-control"
                    ]
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
                'data_class' => Brand::class,
            ]
        );
    }
}
