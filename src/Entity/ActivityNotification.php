<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ActivityNotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ActivityNotificationRepository::class)]

#[ORM\Table(name: '`lotissements_activity_notifications`')]

class ActivityNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]

    private ?string $type = null;

    #[ORM\Column(length: 255)]

    private ?string $message = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]

    private ?\DateTimeImmutable $dateOperation = null;

    #[ORM\ManyToOne]

    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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
}
