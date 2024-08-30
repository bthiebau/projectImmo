<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, BienImmo>
     */
    #[ORM\OneToMany(targetEntity: BienImmo::class, mappedBy: 'city', orphanRemoval: true)]
    private Collection $bienImmo;

    public function __construct()
    {
        $this->bienImmo = new ArrayCollection();
    }

    public function __tostring(){
        return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, BienImmo>
     */
    public function getBienImmo(): Collection
    {
        return $this->bienImmo;
    }

    public function addBienImmo(BienImmo $bienImmo): static
    {
        if (!$this->bienImmo->contains($bienImmo)) {
            $this->bienImmo->add($bienImmo);
            $bienImmo->setCity($this);
        }

        return $this;
    }

    public function removeBienImmo(BienImmo $bienImmo): static
    {
        if ($this->bienImmo->removeElement($bienImmo)) {
            // set the owning side to null (unless already changed)
            if ($bienImmo->getCity() === $this) {
                $bienImmo->setCity(null);
            }
        }

        return $this;
    }
}
