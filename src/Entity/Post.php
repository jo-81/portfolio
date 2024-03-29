<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\InheritanceType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(
    name: 'discr',
    type: 'string')
]
#[DiscriminatorMap(
    typeProperty: 'discr',
    mapping: ['post' => 'Post', 'project' => 'Project', 'article' => 'Article'])
]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity('title')]
abstract class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Sequentially([
        new NotBlank(),
        new Length(min: 6, minMessage: 'Le titre du post doit avoir au minimum {{ limit }} caractères'),
    ])]
    protected ?string $title = null;

    #[ORM\Column]
    protected ?bool $published = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    protected ?string $link = null;

    #[ORM\Column]
    protected ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    protected ?\DateTimeImmutable $editedAt = null;

    #[ORM\ManyToMany(targetEntity: Competence::class, inversedBy: 'posts')]
    protected Collection $competences;

    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'post', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->competences = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEditedAt(): ?\DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(\DateTimeImmutable $editedAt): static
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): static
    {
        if (!$this->competences->contains($competence)) {
            $this->competences->add($competence);
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): static
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }

    #[ORM\PrePersist]
    public function setValueDateTime(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->editedAt = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function setPublishedValue(): void
    {
        $this->published = true;
    }

    #[ORM\PreUpdate]
    public function setValueEditedAt(): void
    {
        $this->editedAt = new \DateTimeImmutable();
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setPost($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getPost() === $this) {
                $image->setPost(null);
            }
        }

        return $this;
    }
}
