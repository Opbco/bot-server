<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\StructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
#[ApiResource]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["structure.details", "structure.list"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["structure.details", "structure.list"])]
    private ?string $name = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Groups(["structure.details", "structure.list"])]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(["structure.details", "structure.list"])]
    private ?string $codeHierarchic = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["structure.details", "structure.list"])]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Groups(["structure.details", "structure.list"])]
    private ?string $contacts = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["structure.details", "structure.list"])]
    private ?Order $ordre = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["structure.details", "structure.list "])]
    private ?FormStructure $forme = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["structure.details", "structure.list"])]
    private ?SubDivision $subdivision = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["structure.details", "structure.list"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_created = null;
  
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["structure.details"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["structure.details", "structure.list"])]
    private ?User $user_created = null;

    #[ORM\ManyToOne]
    private ?User $user_updated = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["structure.details", "structure.list"])]
    private ?Langue $langue = null;

    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["structure.details", "structure.list "])]
    private ?RankStructure $rank = null;

    #[ORM\ManyToOne(inversedBy: 'structures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeStructure $typeStructure = null;

    #[ORM\OneToMany(mappedBy: 'structure', targetEntity: Personne::class)]
    private Collection $personnes;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->personnes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name . ' ( ' . $this->code . ' )';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getCodeHierarchic(): ?string
    {
        return $this->codeHierarchic;
    }

    public function setCodeHierarchic(string $codeHierarchic): self
    {
        $this->codeHierarchic = $codeHierarchic;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function setContacts(string $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function getOrdre(): ?Order
    {
        return $this->ordre;
    }

    public function setOrdre(?Order $ordre): self
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getForme(): ?FormStructure
    {
        return $this->forme;
    }

    public function setForme(?FormStructure $forme): self
    {
        $this->forme = $forme;

        return $this;
    }

    public function getSubdivision(): ?SubDivision
    {
        return $this->subdivision;
    }

    public function setSubdivision(?SubDivision $subdivision): self
    {
        $this->subdivision = $subdivision;

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

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setStructure($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getStructure() === $this) {
                $service->setStructure(null);
            }
        }

        return $this;
    }

    public function getRank(): ?RankStructure
    {
        return $this->rank;
    }

    public function setRank(?RankStructure $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getTypeStructure(): ?TypeStructure
    {
        return $this->typeStructure;
    }

    public function setTypeStructure(?TypeStructure $typeStructure): self
    {
        $this->typeStructure = $typeStructure;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getPersonnes(): Collection
    {
        return $this->personnes;
    }

    public function addPersonne(Personne $personne): self
    {
        if (!$this->personnes->contains($personne)) {
            $this->personnes->add($personne);
            $personne->setStructure($this);
        }

        return $this;
    }

    public function removePersonne(Personne $personne): self
    {
        if ($this->personnes->removeElement($personne)) {
            // set the owning side to null (unless already changed)
            if ($personne->getStructure() === $this) {
                $personne->setStructure(null);
            }
        }

        return $this;
    }
}
