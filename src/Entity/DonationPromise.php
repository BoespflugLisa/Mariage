<?php

namespace App\Entity;

use App\Repository\DonationPromiseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DonationPromiseRepository::class)]
class DonationPromise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $donationAmount = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;
    

    #[ORM\ManyToOne(inversedBy: 'donationPromises')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Present $present = null;

    #[ORM\Column]
    private ?bool $view = false;

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

    public function getDonationAmount(): ?float
    {
        return $this->donationAmount;
    }

    public function setDonationAmount(float $donationAmount): static
    {
        $this->donationAmount = $donationAmount;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPresent(): ?Present
    {
        return $this->present;
    }

    public function setPresent(?Present $present): static
    {
        $this->present = $present;

        return $this;
    }

    public function getView(): ?bool
    {
        return $this->view;
    }

    public function setView(?bool $view): static
    {
        $this->view = $view;

        return $this;
    }
}
