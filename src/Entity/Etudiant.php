<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $motivation = null;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: Module::class)]
    private Collection $id_module;

    #[ORM\OneToMany(mappedBy: 'etudiant', targetEntity: NiveauScolaire::class)]
    private Collection $id_niveauScolaire;

    public function __construct()
    {
        $this->id_module = new ArrayCollection();
        $this->id_niveauScolaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(string $motivation): static
    {
        $this->motivation = $motivation;

        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getIdModule(): Collection
    {
        return $this->id_module;
    }

    public function addIdModule(Module $idModule): static
    {
        if (!$this->id_module->contains($idModule)) {
            $this->id_module->add($idModule);
            $idModule->setEtudiant($this);
        }

        return $this;
    }

    public function removeIdModule(Module $idModule): static
    {
        if ($this->id_module->removeElement($idModule)) {
            // set the owning side to null (unless already changed)
            if ($idModule->getEtudiant() === $this) {
                $idModule->setEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, NiveauScolaire>
     */
    public function getIdNiveauScolaire(): Collection
    {
        return $this->id_niveauScolaire;
    }

    public function addIdNiveauScolaire(NiveauScolaire $idNiveauScolaire): static
    {
        if (!$this->id_niveauScolaire->contains($idNiveauScolaire)) {
            $this->id_niveauScolaire->add($idNiveauScolaire);
            $idNiveauScolaire->setEtudiant($this);
        }

        return $this;
    }

    public function removeIdNiveauScolaire(NiveauScolaire $idNiveauScolaire): static
    {
        if ($this->id_niveauScolaire->removeElement($idNiveauScolaire)) {
            // set the owning side to null (unless already changed)
            if ($idNiveauScolaire->getEtudiant() === $this) {
                $idNiveauScolaire->setEtudiant(null);
            }
        }

        return $this;
    }
}
