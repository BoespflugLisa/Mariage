<?php

namespace App\Entity;

use App\Repository\PresentCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresentCategoryRepository::class)]
class PresentCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'presentCategory', targetEntity: Present::class)]
    private Collection $presents;

    public function __construct()
    {
        $this->presents = new ArrayCollection();
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
     * @return Collection<int, Present>
     */
    public function getPresents(): Collection
    {
        return $this->presents;
    }

    public function addPresent(Present $present): static
    {
        if (!$this->presents->contains($present)) {
            $this->presents->add($present);
            $present->setPresentCategory($this);
        }

        return $this;
    }

    public function removePresent(Present $present): static
    {
        if ($this->presents->removeElement($present)) {
            // set the owning side to null (unless already changed)
            if ($present->getPresentCategory() === $this) {
                $present->setPresentCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
