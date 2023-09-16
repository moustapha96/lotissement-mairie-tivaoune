<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LotissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LotissementRepository::class)]

#[ORM\Table(name: '`lotissements_lotissements`')]
class Lotissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["write", "read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["write", "read"])]
    private ?string $denomination = null;

    #[ORM\Column(length: 255)]
    #[Groups(["write", "read"])]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'lotissement', targetEntity: Parcelle::class)]
    #[Groups(["write", "read"])]
    private Collection $parcelles;


    #[ORM\OneToMany(mappedBy: 'lotissement', targetEntity: Demande::class)]
    #[Groups(["write", "read"])]
    private Collection $demandes;

    #[ORM\ManyToMany(targetEntity: Plan::class, inversedBy: 'lotissements', cascade: ["persist"])]
    #[ORM\JoinTable(name: "lotissements_lotissement_plans")]
    #[Groups(["write", "read"])]
    private Collection $plans;


    #[ORM\ManyToOne(inversedBy: 'lotissements', targetEntity: Localite::class, cascade: ["persist"])]
    #[Groups(["write", "read"])]
    private ?Localite $localite = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]

    private ?string $numero = null;


    public function __construct()
    {
        $this->parcelles = new ArrayCollection();

        $this->demandes = new ArrayCollection();
        $this->plans = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

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

    /**
     * @return Collection<int, Parcelle>
     */
    public function getParcelles(): Collection
    {
        return $this->parcelles;
    }

    public function addParcelle(Parcelle $parcelle): self
    {
        if (!$this->parcelles->contains($parcelle)) {
            $this->parcelles->add($parcelle);
            $parcelle->setLotissement($this);
        }

        return $this;
    }

    public function removeParcelle(Parcelle $parcelle): self
    {
        if ($this->parcelles->removeElement($parcelle)) {
            // set the owning side to null (unless already changed)
            if ($parcelle->getLotissement() === $this) {
                $parcelle->setLotissement(null);
            }
        }

        return $this;
    }


    public function removeAllPlan()
    {
        $this->plans = new ArrayCollection();
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
            $demande->setLotissement($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getLotissement() === $this) {
                $demande->setLotissement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Plan>
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plan $plan): self
    {
        if (!$this->plans->contains($plan)) {
            $this->plans->add($plan);
        }

        return $this;
    }

    public function removePlan(Plan $plan): self
    {
        $this->plans->removeElement($plan);

        return $this;
    }

    public function getLocalite(): ?Localite
    {
        return $this->localite;
    }

    public function setLocalite(?Localite $localite): self
    {
        $this->localite = $localite;

        return $this;
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

    public function asArrayParcelles(): array
    {
        $resultat = [];
        foreach ($this->getParcelles() as $key => $value) {
            $resultat[] = $value->asArray();
        }
        return $resultat;
    }

    public function asArrayPlans(): array
    {
        $resultat = [];
        foreach ($this->getPlans() as $key => $value) {
            $resultat[] = $value->asArraySimple();
        }
        return $resultat;
    }


    public function asArray(): array
    {

        return [
            'id' => $this->getId(),
            'denomination' => $this->getDenomination(),
            'adresse' => $this->getAdresse(),
            'parcelles' => $this->asArrayParcelles(),
            'plans' => $this->asArrayPlans(),
            'demandes' => $this->getDemandes(),
            'localite' => $this->getLocalite()->asArray(),
            'numero' => $this->getNumero()
        ];
    }
    public function asArraySimple(): array
    {

        return [
            'id' => $this->getId(),
            'denomination' => $this->getDenomination(),
            'adresse' => $this->getAdresse(),
            'numero' => $this->getNumero()
        ];
    }
}
