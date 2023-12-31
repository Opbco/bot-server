<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FonctionFormStructureRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: FonctionFormStructureRepository::class)]
#[ApiResource]
class FonctionFormStructure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["fonction.details"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fonctionFormStructures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["fonction.details"])]
    private ?FormStructure $formstructure = null;

    #[ORM\ManyToOne(inversedBy: 'fonctionFormStructures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Fonction $fonction = null;

    #[ORM\Column(options: ["default" => 0])]
    #[Groups(["fonction.details"])]
    private ?int $nbPosition = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_created = null;

    #[ORM\ManyToOne]
    private ?User $user_updated = null;

    public function __toString()
    {
        return $this->nbPosition . ' ' . $this->fonction . ' - ' . $this->formstructure;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormstructure(): ?FormStructure
    {
        return $this->formstructure;
    }

    public function setFormstructure(?FormStructure $formstructure): self
    {
        $this->formstructure = $formstructure;

        return $this;
    }

    public function getFonction(): ?Fonction
    {
        return $this->fonction;
    }

    public function setFonction(?Fonction $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getNbPosition(): ?int
    {
        return $this->nbPosition;
    }

    public function setNbPosition(int $nbPosition): self
    {
        $this->nbPosition = $nbPosition;

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
}
