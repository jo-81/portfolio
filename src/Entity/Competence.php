<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompetenceRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('name')]
#[UniqueEntity('slug')]
class Competence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\Column(length: 30)]
    #[Assert\CssColor]
    private ?string $color = null;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    #[ORM\PrePersist]
    public function setPublishedValue(): void
    {
        $this->published = true;
    }

    #[ORM\PrePersist]
    public function setSlugValue(): void
    {
        $slugger = new AsciiSlugger();
        if ($this->name) {
            $this->slug = strtolower($slugger->slug($this->name));
        }
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
