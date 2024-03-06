<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BordereauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: BordereauRepository::class)]
#[ApiResource]
class Bordereau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $emetteur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $recepteur = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\ManyToMany(targetEntity: Dossier::class, inversedBy: 'bordereaus')]
    private Collection $dossiers;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["bordereau.details", "bordereau.list"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["bordereau.details"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["bordereau.details", "bordereau.list"])]
    private ?User $user_created = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user_updated = null;

    public function __construct()
    {
        $this->dossiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmetteur(): ?Service
    {
        return $this->emetteur;
    }

    public function setEmetteur(?Service $emetteur): self
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    public function getRecepteur(): ?Service
    {
        return $this->recepteur;
    }

    public function setRecepteur(?Service $recepteur): self
    {
        $this->recepteur = $recepteur;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection<int, Dossier>
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(Dossier $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers->add($dossier);
        }

        return $this;
    }

    public function setDossiers(Collection $dossiers): void
    {
        $this->dossiers = new ArrayCollection;

        foreach ($dossiers as $one) {
            $this->addDossier($one);
        }
    }

    public function removeDossier(Dossier $dossier): self
    {
        $this->dossiers->removeElement($dossier);

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->date_updated;
    }

    public function setDateUpdated(?\DateTimeInterface $date_updated): self
    {
        $this->date_updated = $date_updated;

        return $this;
    }

    public function getUserCreated(): ?User
    {
        return $this->user_created;
    }

    public function setUserCreated(?User $user_created): self
    {
        $this->user_created = $user_created;

        return $this;
    }

    public function getUserUpdated(): ?User
    {
        return $this->user_updated;
    }

    public function setUserUpdated(?User $user_updated): self
    {
        $this->user_updated = $user_updated;

        return $this;
    }

    public function __toString()
    {
        return $this->emetteur. ' --> ' .$this->recepteur. ' '.$this->date_created->format("YYYY mm dd"); 
    }
}
