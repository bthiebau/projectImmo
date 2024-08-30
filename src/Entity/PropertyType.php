<?php

namespace App\Entity;

use App\Repository\PropertyTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyTypeRepository::class)]
class PropertyType
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
    #[ORM\OneToMany(targetEntity: BienImmo::class, mappedBy: 'propertyType')]
    private Collection $BienImmo;

    public function __construct()
    {
        $this->BienImmo = new ArrayCollection();
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
        return $this->BienImmo;
    }

    public function addBienImmo(BienImmo $bienImmo): static
    {
        if (!$this->BienImmo->contains($bienImmo)) {
            $this->BienImmo->add($bienImmo);
            $bienImmo->setPropertyType($this);
        }

        return $this;
    }

    public function removeBienImmo(BienImmo $bienImmo): static
    {
        if ($this->BienImmo->removeElement($bienImmo)) {
            // set the owning side to null (unless already changed)
            if ($bienImmo->getPropertyType() === $this) {
                $bienImmo->setPropertyType(null);
            }
        }

        return $this;
    }
}
