<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your model must be at least {{ limit }} characters long",
     *      maxMessage = "Your model cannot be longer than {{ limit }} characters"
     * )
     */
    private $model;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gear;

    /**
     * @ORM\ManyToOne(targetEntity=Energy::class, inversedBy="cars", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $energy;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="cars",fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="cars",fetch="EAGER", cascade={"remove", "persist"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getGear(): ?bool
    {
        return $this->gear;
    }

    public function setGear(bool $gear): self
    {
        $this->gear = $gear;

        return $this;
    }

    public function getEnergy(): ?Energy
    {
        return $this->energy;
    }

    public function setEnergy(?Energy $energy): self
    {
        $this->energy = $energy;

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

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCars($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCars() === $this) {
                $image->setCars(null);
            }
        }

        return $this;
    }


}
