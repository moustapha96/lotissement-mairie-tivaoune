<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LocaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LocaliteRepository::class)]


#[ORM\Table(name: '`lotissements_localites`')]

class Localite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["write", "read"])]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    #[Groups(["write", "read"])]
    private ?string $denomination = null;

    #[ORM\OneToMany(mappedBy: 'localite', targetEntity: Lotissement::class)]
    #[Groups(["write", "read"])]
    private Collection $lotissements;


    public function __construct()
    {
        $this->lotissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(?string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * @return Collection<int, Lotissement>
     */
    public function getLotissements(): Collection
    {
        return $this->lotissements;
    }

    public function addLotissement(Lotissement $lotissement): self
    {
        if (!$this->lotissements->contains($lotissement)) {
            $this->lotissements->add($lotissement);
            $lotissement->setLocalite($this);
        }

        return $this;
    }

    public function removeLotissement(Lotissement $lotissement): self
    {
        if ($this->lotissements->removeElement($lotissement)) {
            // set the owning side to null (unless already changed)
            if ($lotissement->getLocalite() === $this) {
                $lotissement->setLocalite(null);
            }
        }

        return $this;
    }

    
    public function asArray(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'denomination' => $this->getDenomination(),

        ];
    }
}