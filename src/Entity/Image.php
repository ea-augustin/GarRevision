<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @UniqueEntity("name", message ="This image exsits already")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private mixed $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File (
     *     maxSize = "5024k",
     *     mimeTypes = {"image/jepg", "image/png"},
     *     mimeTypesMessage = "Please upload a valid jpeg/png"
     * )
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\OneToOne(targetEntity=Brand::class, inversedBy="logo", cascade={"persist", "remove"})
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Car::class, inversedBy="images",fetch="EAGER")
     */
    private $cars;

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(mixed $name): void
    {
        $this->name = $name;
    }



    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCars(): ?Car
    {
        return $this->cars;
    }

    public function setCars(?Car $cars): self
    {
        $this->cars = $cars;

        return $this;
    }

    public function __toString()
    {
        return $this->url;
    }
}
