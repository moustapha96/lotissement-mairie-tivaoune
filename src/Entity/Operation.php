<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\OperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OperationRepository::class)]


#[ORM\Table(name: '`lotissements_operations`')]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255)]

    private ?string $operation = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]

    private ?\DateTimeImmutable $dateOperation = null;

    #[ORM\ManyToOne]

    private ?User $user = null;


    #[ORM\ManyToOne]

    private ?Demande $demande = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperation(): ?string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): self
    {
        $this->operation = $operation;

        return $this;
    }

    public function getDateOperation(): ?\DateTimeImmutable
    {
        return $this->dateOperation;
    }

    public function setDateOperation(\DateTimeImmutable $dateOperation): self
    {
        $this->dateOperation = $dateOperation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        $this->demande = $demande;

        return $this;
    }
}
