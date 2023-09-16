<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Table(name: '`lotissements_plans`')]
#[ORM\Entity(repositoryClass: PlanRepository::class)]
class Plan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $statut = null;


    // #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $fichier = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Lotissement::class, mappedBy: 'plans', cascade: ["persist"])]
    #[ORM\JoinTable(name: "lotissements_lotissement_plans")]
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





    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFichier(): array
    {
        if ($this->fichier == null) {
            return [];
        }
        return $this->fichier;
    }

    public function setFichier(?array $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function isStatut(): ?bool
    {
        if ($this->statut == null) {
            return false;
        }
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

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
            $lotissement->addPlan($this);
        }

        return $this;
    }

    public function removeLotissement(Lotissement $lotissement): self
    {
        if ($this->lotissements->removeElement($lotissement)) {
            $lotissement->removePlan($this);
        }

        return $this;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'description' => $this->getDescription(),
            'lotissement' => $this->getLotissements(),
            'statut' => $this->isStatut(),
            'fichier' => $this->getFichier()
        ];
    }
    public function asArraySimple(): array
    {
        return [
            'id' => $this->getId(),
            'type' => $this->getType(),
            'description' => $this->getDescription(),

            'statut' => $this->isStatut(),
            'fichier' => $this->getFichier()

        ];
    }
}
