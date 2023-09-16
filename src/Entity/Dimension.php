<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DimensionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DimensionRepository::class)]

#[ORM\Table(name: '`lotissements_dimensions`')]
class Dimension
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?float $longueur = null;

    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?float $largeur = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["write", "read"])]
    private ?float $superficie = null;


    public $formattedDimensions;

    public function __construct()
    {
        // Vous pouvez initialiser la propriété non annotée dans le constructeur si nécessaire
        $this->formattedDimensions =
            $this->longueur . 'm x ' . $this->largeur . 'm';
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(float $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }
    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(?float $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }
}
