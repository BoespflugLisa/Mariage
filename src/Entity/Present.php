<?php

namespace App\Entity;

use App\Repository\PresentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;


#[ORM\Entity(repositoryClass: PresentRepository::class)]
class Present
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'present', targetEntity: DonationPromise::class, orphanRemoval: true)]
    private Collection $donationPromises;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    private ?float $totalAmount = null;

    private ?float $progression = null;
    
    #[ORM\Column(nullable: true)]
    private ?int $parentId = null;

    private ?bool $isComplete = false;

    #[ORM\ManyToOne(inversedBy: 'presents')]
    private ?PresentCategory $presentCategory = null;


    public function __construct()
    {
        $this->donationPromises = new ArrayCollection();
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(int $parentId): static
    {
        $this->parentId = $parentId;

        return $this;
    }
    /**
     * @return Collection<int, DonationPromise>
     */
    public function getDonationPromises(): Collection
    {
        return $this->donationPromises;
    }

    public function addDonationPromise(DonationPromise $donationPromise): static
    {
        if (!$this->donationPromises->contains($donationPromise)) {
            $this->donationPromises->add($donationPromise);
            $donationPromise->setPresent($this);
        }

        return $this;
    }

    public function removeDonationPromise(DonationPromise $donationPromise): static
    {
        if ($this->donationPromises->removeElement($donationPromise)) {
            // set the owning side to null (unless already changed)
            if ($donationPromise->getPresent() === $this) {
                $donationPromise->setPresent(null);
            }
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount() : static
    {   
        $count = 0;

        foreach ($this->getDonationPromises() as $donationPromise) {
            $count += $donationPromise->getDonationAmount();
        }
        $this->totalAmount = $count;
        return $this;
    }

    public function getProgression(): ?float
    {
        return $this->progression;
    }

    public function setProgression() : static
    {   
        $percent = ($this->getTotalAmount()/$this->getPrice())*100;
        
        $this->progression = $percent;
        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }


    public function isComplete(): ?bool
    {
        return $this->isComplete;
    }

    public function setComplete(bool $complete): static
    {
        $this->isComplete = $complete;

        return $this;
    }

    public function getPresentCategory(): ?PresentCategory
    {
        return $this->presentCategory;
    }

    public function setPresentCategory(?PresentCategory $presentCategory): static
    {
        $this->presentCategory = $presentCategory;

        return $this;
    }
}
