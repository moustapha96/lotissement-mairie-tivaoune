<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ParametrageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParametrageRepository::class)]

#[ORM\Table(name: '`lotissements_parametrages`')]

class Parametrage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    // #[ORM\Column(length: 255, nullable: true)]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["write", "read"])]
    private ?string $logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["write", "read"])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["write", "read"])]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}