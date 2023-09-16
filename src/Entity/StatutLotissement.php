<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StatutLotissementRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StatutLotissementRepository::class)]



#[ORM\Table(name: '`lotissements_statuts_lotissements`')]

class StatutLotissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["write", "read"])]
    private ?string $denomination = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["write", "read"])]
    private ?bool $status = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function asArray(): array
    {

        return [
            'id' => $this->getId(),

            'denomination' => $this->getDenomination(),
            'status' => $this->isStatus()
        ];
    }
}