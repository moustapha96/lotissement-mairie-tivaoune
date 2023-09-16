<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DemandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\File\File;



#[ORM\Entity(repositoryClass: DemandeRepository::class)]

#[ORM\Table(name: '`lotissements_demandes`')]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $numero = null;

    #[ORM\Column]

    private ?\DateTimeImmutable $dateDemande = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]

    private $demandeAdresseMaire = null;


    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private $cni = null;

    #[ORM\ManyToOne(targetEntity: Demandeur::class, inversedBy: 'demandes', cascade: ['persist'])]

    private ?Demandeur $demandeur = null;

    #[ORM\ManyToOne(inversedBy: 'demandes')]

    private ?Lotissement $lotissement = null;


    #[ORM\ManyToOne]
    #[Groups(["write", "read"])]
    private ?StatutLotissement $statut = null;


    public function __construct()
    {
        $this->dateDemande = new \DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {

        $timestamp = strtotime('now');
        // if ($numero != null) {
        //     $this->numero = $numero;
        // } else {
        //     $this->numero = $timestamp;
        // }
        $this->numero = $timestamp;
        return $this;
    }

    public function getDateDemande(): ?\DateTimeImmutable
    {
        return $this->dateDemande;
    }

    public function setDateDemande(\DateTimeImmutable $dateDemande): self
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    public function getDemandeAdresseMaire()
    {

        return $this->demandeAdresseMaire;
        $fileN = substr($this->demandeAdresseMaire, 0);

        if (file_exists($fileN)) {
            return new File($fileN);
        }
        return null;
    }

    public function setDemandeAdresseMaire($demandeAdresseMaire): self
    {
        $this->demandeAdresseMaire = $demandeAdresseMaire;

        return $this;
    }

    public function getCni()
    {
        return $this->cni;
        $fileN = substr($this->cni, 0);
        if (file_exists($fileN)) {
            return new File($fileN);
        }
        return null;
    }

    public function setCni($cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getDemandeur(): ?Demandeur
    {
        return $this->demandeur;
    }

    public function setDemandeur(?Demandeur $demandeur): self
    {
        $this->demandeur = $demandeur;

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

    public function getStatut(): ?StatutLotissement
    {
        return $this->statut;
    }

    public function setStatut(?StatutLotissement $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->getId(),
            'cni' => $this->getCni(),
            'numero' => $this->getNumero(),
            'dateDemande' => $this->getDateDemande(),
            'demandeAdresseMaire' => $this->getDemandeAdresseMaire(),
            'lotissement' => $this->getLotissement() ? $this->getLotissement() : null,
            'statut' => $this->getStatut()->asArray(),
            'demandeur' => $this->getDemandeur() ? $this->getDemandeur()->asArray() : null
        ];
    }
}
