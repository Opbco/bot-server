<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DossierRepository::class)]
#[ApiResource]
class Dossier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $objet = null;

    #[ORM\ManyToOne(inversedBy: 'dossiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personne $personne = null;

    #[ORM\ManyToOne(inversedBy: 'dossiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDossier $typeDossier = null;

    #[ORM\Column(options: ['default' => 0])]
    private ?int $statut = null;

    #[ORM\OneToMany(mappedBy: 'dosssier', targetEntity: PieceDossier::class, cascade: ['persist', 'remove'])]
    private Collection $pieces;

    #[ORM\OneToMany(mappedBy: 'dossier', targetEntity: PieceToComplete::class, cascade: ['persist', 'remove'])]
    private Collection $pieceToCompletes;

    #[ORM\ManyToOne(inversedBy: 'dossiers')]
    #[ORM\JoinColumn(nullable:true)]
    private ?Service $service = null;

    #[ORM\ManyToMany(targetEntity: Bordereau::class, mappedBy: 'dossiers')]
    private Collection $bordereaus;

    public function __construct()
    {
        $this->pieces = new ArrayCollection();
        $this->pieceToCompletes = new ArrayCollection();
        $this->bordereaus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): self
    {
        $this->objet = $objet;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getTypeDossier(): ?TypeDossier
    {
        return $this->typeDossier;
    }

    public function setTypeDossier(?TypeDossier $typeDossier): self
    {
        $this->typeDossier = $typeDossier;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, PieceDossier>
     */
    public function getPieces(): Collection
    {
        return $this->pieces;
    }

    public function addPiece(PieceDossier $piece): self
    {
        if (!$this->pieces->contains($piece)) {
            $this->pieces->add($piece);
            $piece->setDosssier($this);
        }

        return $this;
    }

    public function removePiece(PieceDossier $piece): self
    {
        if ($this->pieces->removeElement($piece)) {
            // set the owning side to null (unless already changed)
            if ($piece->getDossier() === $this) {
                $piece->setDosssier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PieceToComplete>
     */
    public function getPieceToCompletes(): Collection
    {
        return $this->pieceToCompletes;
    }

    public function addPieceToComplete(PieceToComplete $pieceToComplete): self
    {
        if (!$this->pieceToCompletes->contains($pieceToComplete)) {
            $this->pieceToCompletes->add($pieceToComplete);
            $pieceToComplete->setDossier($this);
        }

        return $this;
    }

    public function removePieceToComplete(PieceToComplete $pieceToComplete): self
    {
        if ($this->pieceToCompletes->removeElement($pieceToComplete)) {
            // set the owning side to null (unless already changed)
            if ($pieceToComplete->getDossier() === $this) {
                $pieceToComplete->setDossier(null);
            }
        }

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, Bordereau>
     */
    public function getBordereaus(): Collection
    {
        return $this->bordereaus;
    }

    public function addBordereau(Bordereau $bordereau): self
    {
        if (!$this->bordereaus->contains($bordereau)) {
            $this->bordereaus->add($bordereau);
            $bordereau->addDossier($this);
        }

        return $this;
    }

    public function removeBordereau(Bordereau $bordereau): self
    {
        if ($this->bordereaus->removeElement($bordereau)) {
            $bordereau->removeDossier($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->typeDossier. ' '. $this->personne;
    }
}
