<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SmsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SmsRepository::class)]


#[ORM\Table(name: '`lotissements_sms`')]
class Sms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]

    private ?string $receiver = null;

    #[ORM\Column(length: 255, nullable: true)]

    private ?string $message = null;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]

    private ?\DateTimeInterface $date = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(?string $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
