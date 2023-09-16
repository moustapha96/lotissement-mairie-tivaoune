<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ParcelleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParcelleRepository::class)]

#[ORM\Table(name: '`lotissements_parcelles`')]
class Parcelle
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    #[Groups(["write", "read"])]
    private ?string $numero = null;

    #[ORM\ManyToOne(inversedBy: 'parcelles', targetEntity: Lotissement::class)]
    #[Groups(["write", "read"])]
    private ?Lotissement $lotissement = null;

    #[ORM\ManyToOne(targetEntity: Dimension::class)]
    #[Groups(["write", "read"])]
    private ?Dimension $dimension = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {

        $timestamp = strtotime('now');
        if ($numero) {
            $this->numero = $numero;
        } else {
            $this->numero = $timestamp;
        }
        return $this;
    }

    public function getLotissement(): ?Lotissement
    {
        return $this->lotissement;
    }

    public function setLotissement(?Lotissement $lotissement): self
    {
        $this->lotissement = $lotissement;

        return $this;
    }

    public function getDimension(): ?Dimension
    {
        return $this->dimension;
    }

    public function setDimension(?Dimension $dimension): self
    {
        $this->dimension = $dimension;

        return $this;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->getId(),
            'numero' => $this->getNumero(),
            'lotissement' => $this->getLotissement()->asArraySimple(),
            'dimension' => $this->getDimension(),

        ];
    }
}