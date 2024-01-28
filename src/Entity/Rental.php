<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalRepository::class)]
class Rental
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rentals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $itemId = null;

    #[ORM\ManyToOne(inversedBy: 'rentals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $rentFrom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $rentTo = null;

    #[ORM\Column(nullable: true)]
    private ?bool $returned = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemId(): ?Book
    {
        return $this->itemId;
    }

    public function setItemId(?Book $itemId): static
    {
        $this->itemId = $itemId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getRentFrom(): ?\DateTimeInterface
    {
        return $this->rentFrom;
    }

    public function setRentFrom(\DateTimeInterface $rentFrom): static
    {
        $this->rentFrom = $rentFrom;

        return $this;
    }

    public function getRentTo(): ?\DateTimeInterface
    {
        return $this->rentTo;
    }

    public function setRentTo(\DateTimeInterface $rentTo): static
    {
        $this->rentTo = $rentTo;

        return $this;
    }

    public function isReturned(): ?bool
    {
        return $this->returned;
    }

    public function setReturned(?bool $returned): static
    {
        $this->returned = $returned;

        return $this;
    }
}
