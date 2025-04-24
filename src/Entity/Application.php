<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $jobTitle = null;

    #[ORM\Column(length: 255)]
    private ?string $companyName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $jobLink = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $applicationDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $jobDescription = null;

    #[ORM\OneToMany(targetEntity: MotivationLetter::class, mappedBy: 'application')]
    private Collection $motivationLetter;

    public function __construct() {
        $this->motivationLetter = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getJobLink(): ?string
    {
        return $this->jobLink;
    }

    public function setJobLink(?string $jobLink): static
    {
        $this->jobLink = $jobLink;

        return $this;
    }

    public function getApplicationDate(): ?\DateTimeImmutable
    {
        return $this->applicationDate;
    }

    public function setApplicationDate(\DateTimeImmutable $applicationDate): static
    {
        $this->applicationDate = $applicationDate;

        return $this;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(?string $jobDescription): static
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    public function getMotivationLetter(): Collection
    {
        return $this->motivationLetter;
    }

    public function addMotivationLetter(MotivationLetter $motivationLetter): self
    {
        if (!$this->motivationLetter->contains($motivationLetter)) {
            $this->motivationLetter[] = $motivationLetter;
            $motivationLetter->setApplication($this);  // On associe l'application à la lettre de motivation
        }

        return $this;
    }

    public function removeMotivationLetter(MotivationLetter $motivationLetter): self
    {
        if ($this->motivationLetter->contains($motivationLetter)) {
            $this->motivationLetter->removeElement($motivationLetter);
            // On supprime également la relation de l'autre côté de l'association
            if ($motivationLetter->getApplication() === $this) {
                $motivationLetter->setApplication(null);
            }
        }

        return $this;
    }

}
