<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RegionRepository::class)]

#[ORM\Table(name: '`lotissements_regions`')]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["write", "read"])]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Departement::class)]
    #[Groups(["write", "read"])]
    private $departement;

    public function __construct()
    {
        $this->departement = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Departement>
     */
    public function getDepartement(): Collection
    {
        return $this->departement;
    }

    public function addDepartement(Departement $departement): self
    {
        if (!$this->departement->contains($departement)) {
            $this->departement->add($departement);
            $departement->setRegion($this);
        }
        return $this;
    }

    public function removeDepartement(Departement $departement): self
    {
        if ($this->departement->removeElement($departement)) {
            // set the owning side to null (unless already changed)
            if ($departement->getRegion() === $this) {
                $departement->setRegion(null);
            }
        }

        return $this;
    }
}