<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PaysRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PaysRepository::class)]

#[ORM\Table(name: '`lotissements_pays`')]
class Pays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["write", "read"])]
    private ?string $nomPays = null;

    #[ORM\Column(length: 255)]
    #[Groups(["write", "read"])]
    private ?string $indicatif = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPays(): ?string
    {
        return $this->nomPays;
    }

    public function setNomPays(string $nomPays): self
    {
        $this->nomPays = $nomPays;

        return $this;
    }

    public function getIndicatif(): ?string
    {
        return $this->indicatif;
    }

    public function setIndicatif(string $indicatif): self
    {
        $this->indicatif = $indicatif;

        return $this;
    }
}
