<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Project extends Post
{
    #[ORM\Column(length: 255)]
    protected ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    protected ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    protected ?string $github = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): static
    {
        $this->github = $github;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }

    #[ORM\PrePersist]
    public function setSlugValue(): void
    {
        $slugger = new AsciiSlugger();
        if ($this->title) {
            $this->slug = strtolower($slugger->slug($this->title));
        }
    }
}
