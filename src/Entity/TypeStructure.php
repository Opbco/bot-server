<?php

namespace App\Entity;

use App\Repository\TypeStructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: TypeStructureRepository::class)]
class TypeStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["type.details", "type.list", "form.details"])]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Groups(["type.details", "type.list", "form.details"])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'typeStructures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["type.details", "form.details"])]
    private ?Category $category = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["type.details", "type.list"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["type.details"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["type.details", "type.list"])]
    private ?User $user_created = null;

    #[ORM\ManyToOne]
    private ?User $user_updated = null;

    #[ORM\OneToMany(mappedBy: 'typeStructure', targetEntity: FormStructure::class, orphanRemoval: true)]
    private Collection $formStructures;

    public function __construct()
    {
        $this->formStructures = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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

    /**
     * @return Collection<int, FormStructure>
     */
    public function getFormStructures(): Collection
    {
        return $this->formStructures;
    }

    public function addFormStructure(FormStructure $formStructure): self
    {
        if (!$this->formStructures->contains($formStructure)) {
            $this->formStructures->add($formStructure);
            $formStructure->setTypeStructure($this);
        }

        return $this;
    }

    public function removeFormStructure(FormStructure $formStructure): self
    {
        if ($this->formStructures->removeElement($formStructure)) {
            // set the owning side to null (unless already changed)
            if ($formStructure->getTypeStructure() === $this) {
                $formStructure->setTypeStructure(null);
            }
        }

        return $this;
    }
}
