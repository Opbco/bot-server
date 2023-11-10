<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SubDivisionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: SubDivisionRepository::class)]
#[ApiResource]
class SubDivision
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["subdivision.details", "subdivision.list"])]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Groups(["subdivision.details", "subdivision.list"])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'subDivisions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["subdivision.details"])]
    private ?Division $division = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["subdivision.details", "subdivision.list"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["subdivision.details"])]
    #[Context(
        normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d H:i'],
        denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => \DateTime::RFC3339],
    )]
    private ?\DateTimeInterface $date_updated = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["subdivision.details", "subdivision.list"])]
    private ?User $user_created = null;

    #[ORM\ManyToOne]
    private ?User $user_updated = null;

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

    public function getDivision(): ?Division
    {
        return $this->division;
    }

    public function setDivision(?Division $division): self
    {
        $this->division = $division;

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
}
