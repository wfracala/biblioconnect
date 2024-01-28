<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $author;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Review::class)]
    private Collection $reviews;

    #[ORM\OneToOne(mappedBy: 'book', cascade: ['persist', 'remove'])]
    private ?BookAvailability $availability = null;

    #[ORM\OneToMany(mappedBy: 'itemId', targetEntity: Rental::class)]
    private Collection $rentals;

    public function __construct()
    {
        $this->author = new ArrayCollection();
        $this->reviews = new ArrayCollection();
        $this->rentals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->author->removeElement($author);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setBook($this);
        }

        return $this;
    }

    public function removeReview(Review $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getBook() === $this) {
                $review->setBook(null);
            }
        }

        return $this;
    }

    public function getAvailability(): ?BookAvailability
    {
        return $this->availability;
    }

    public function setAvailability(?BookAvailability $availability): static
    {
        // unset the owning side of the relation if necessary
        if ($availability === null && $this->availability !== null) {
            $this->availability->setBook(null);
        }

        // set the owning side of the relation if necessary
        if ($availability !== null && $availability->getBook() !== $this) {
            $availability->setBook($this);
        }

        $this->availability = $availability;

        return $this;
    }

    /**
     * @return Collection<int, Rental>
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental): static
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals->add($rental);
            $rental->setItemId($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): static
    {
        if ($this->rentals->removeElement($rental)) {
            // set the owning side to null (unless already changed)
            if ($rental->getItemId() === $this) {
                $rental->setItemId(null);
            }
        }

        return $this;
    }
}
