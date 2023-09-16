<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DemandeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DemandeurRepository::class)]

#[ORM\Table(name: '`lotissements_demandeurs`')]
class Demandeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255)]

    private ?string $prenom = null;

    #[ORM\Column(length: 255)]

    private ?string $nom = null;

    #[ORM\Column(length: 255)]

    private ?string $adresse = null;

    #[ORM\Column(length: 13)]

    private ?string $telephone = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]

    private ?\DateTime $dateNaissance = null;

    #[ORM\Column(length: 255)]

    private ?string $lieuNaissance = null;


    #[ORM\Column(type: 'string', nullable: true, length: 255, unique: true)]

    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'demandeur', targetEntity: Demande::class)]

    private Collection $demandes;

    #[ORM\Column(length: 13)]

    private ?string $nin = null;

    #[ORM\Column(length: 255)]

    private ?string $adresseResidentielle = null;

    #[ORM\Column(length: 255)]

    private ?string $civilite = null;

    #[ORM\Column(length: 255)]

    private ?string $situationMatrimoniale = null;

    #[ORM\Column(length: 255)]

    private ?string $nationalite = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]

    private ?User $compte = null;

    #[ORM\ManyToOne]

    private ?Statut $statut = null;


    public function __construct()
    {
        $this->demandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }




    public function getLieuNaissance(): ?string
    {
        return $this->lieuNaissance;
    }

    public function setLieuNaissance(string $lieuNaissance): self
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes->add($demande);
            $demande->setDemandeur($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getDemandeur() === $this) {
                $demande->setDemandeur(null);
            }
        }

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNin(): ?string
    {
        return $this->nin;
    }

    public function setNin(string $nin): self
    {
        $this->nin = $nin;

        return $this;
    }

    public function getAdresseResidentielle(): ?string
    {
        return $this->adresseResidentielle;
    }

    public function setAdresseResidentielle(string $adresseResidentielle): self
    {
        $this->adresseResidentielle = $adresseResidentielle;

        return $this;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(string $civilite): self
    {
        $this->civilite = $civilite;

        return $this;
    }

    public function getSituationMatrimoniale(): ?string
    {
        return $this->situationMatrimoniale;
    }

    public function setSituationMatrimoniale(string $situationMatrimoniale): self
    {
        $this->situationMatrimoniale = $situationMatrimoniale;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(?User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getStatut(): ?Statut
    {
        return $this->statut;
    }

    public function setStatut(?Statut $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function asArray(): array
    {

        return [
            'id' => $this->getId(),
            'nom' => $this->getNom(),
            'prenom' => $this->getPrenom(),
            'adresse' => $this->getAdresse(),
            'lieuNaissance' => $this->getLieuNaissance(),
            'telephone' => $this->getTelephone(),
            'dateNaissance' => $this->getDateNaissance(),
            'email' => $this->getEmail(),
            'nin' => $this->getNin(),
            'adresseResidentielle' => $this->getAdresseResidentielle(),
            'civilite' => $this->getCivilite(),
            'situationMatrimoniale' => $this->getSituationMatrimoniale(),
            'nationalite' => $this->getNationalite(),
            'statut' => $this->getStatut(),
            'compte' => $this->getCompte(),
        ];
    }
}
