<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PieceRequiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: PieceRequiseRepository::class)]
#[ApiResource]
class PieceRequise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["piece.details", "piece.list"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["piece.details", "piece.list"])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["piece.details", "piece.list"])]
    private ?string $signataire = null;

    #[ORM\OneToMany(mappedBy: 'pieceRequise', targetEntity: TypeDocumentPieces::class)]
    private Collection $typeDocumentPieces;

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

    public function __construct()
    {
        $this->typeDocumentPieces = new ArrayCollection();
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

    public function getSignataire(): ?string
    {
        return $this->signataire;
    }

    public function setSignataire(string $signataire): self
    {
        $this->signataire = $signataire;

        return $this;
    }

    /**
     * @return Collection<int, TypeDocumentPieces>
     */
    public function getTypeDocumentPieces(): Collection
    {
        return $this->typeDocumentPieces;
    }

    public function addTypeDocumentPiece(TypeDocumentPieces $typeDocumentPiece): self
    {
        if (!$this->typeDocumentPieces->contains($typeDocumentPiece)) {
            $this->typeDocumentPieces->add($typeDocumentPiece);
            $typeDocumentPiece->setPieceRequise($this);
        }

        return $this;
    }

    public function removeTypeDocumentPiece(TypeDocumentPieces $typeDocumentPiece): self
    {
        if ($this->typeDocumentPieces->removeElement($typeDocumentPiece)) {
            // set the owning side to null (unless already changed)
            if ($typeDocumentPiece->getPieceRequise() === $this) {
                $typeDocumentPiece->setPieceRequise(null);
            }
        }

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
