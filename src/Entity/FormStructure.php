<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FormStructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: FormStructureRepository::class)]
#[ApiResource]
class FormStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["form.details", "form.list"])]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Groups(["form.details", "form.list"])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'formStructures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["form.details"])]
    private ?TypeStructure $typeStructure = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["form.details", "form.list"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["form.details"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["form.details", "form.list"])]
    private ?User $user_created = null;

    #[ORM\ManyToOne]
    private ?User $user_updated = null;

    #[ORM\OneToMany(mappedBy: 'formstructure', targetEntity: FonctionFormStructure::class, orphanRemoval: true)]
    private Collection $fonctionFormStructures;

    public function __construct()
    {
        $this->fonctionFormStructures = new ArrayCollection();
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

    public function getTypeStructure(): ?TypeStructure
    {
        return $this->typeStructure;
    }

    public function setTypeStructure(?TypeStructure $typeStructure): self
    {
        $this->typeStructure = $typeStructure;

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
        return $this->name;
    }

    /**
     * @return Collection<int, FonctionFormStructure>
     */
    public function getFonctionFormStructures(): Collection
    {
        return $this->fonctionFormStructures;
    }

    public function addFonctionFormStructure(FonctionFormStructure $fonctionFormStructure): self
    {
        if (!$this->fonctionFormStructures->contains($fonctionFormStructure)) {
            $this->fonctionFormStructures->add($fonctionFormStructure);
            $fonctionFormStructure->setFormstructure($this);
        }

        return $this;
    }

    public function removeFonctionFormStructure(FonctionFormStructure $fonctionFormStructure): self
    {
        if ($this->fonctionFormStructures->removeElement($fonctionFormStructure)) {
            // set the owning side to null (unless already changed)
            if ($fonctionFormStructure->getFormstructure() === $this) {
                $fonctionFormStructure->setFormstructure(null);
            }
        }

        return $this;
    }
}
