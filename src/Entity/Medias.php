<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\MediasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: MediasRepository::class)]
/*
 *Ligne de commande doctrine qui permet et participe à la recherche fulltext
 */
#[Index(columns: ["name", "description"], name: "media", flags:["fulltext"])]
class Medias
{
    use CreatedAtTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 800)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MediasSections $mediasSections = null;

    #[ORM\ManyToOne(inversedBy: 'medias')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediasImages::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $mediasImages;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediasMusics::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $mediasMusics;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: MediasVideos::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $mediasVideos;

    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'medias')]
    private Collection $categories;

    public function __construct()
    {
        $this->mediasImages = new ArrayCollection();
        $this->mediasMusics = new ArrayCollection();
        $this->mediasVideos = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMediasSections(): ?MediasSections
    {
        return $this->mediasSections;
    }

    public function setMediasSections(?MediasSections $mediasSections): self
    {
        $this->mediasSections = $mediasSections;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, MediasImages>
     */
    public function getMediasImages(): Collection
    {
        return $this->mediasImages;
    }

    public function addMediasImage(MediasImages $mediasImage): self
    {
        if (!$this->mediasImages->contains($mediasImage)) {
            $this->mediasImages->add($mediasImage);
            $mediasImage->setMedia($this);
        }

        return $this;
    }

    public function removeMediasImage(MediasImages $mediasImage): self
    {
        if ($this->mediasImages->removeElement($mediasImage)) {
            // set the owning side to null (unless already changed)
            if ($mediasImage->getMedia() === $this) {
                $mediasImage->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MediasMusics>
     */
    public function getMediasMusics(): Collection
    {
        return $this->mediasMusics;
    }

    public function addMediasMusic(MediasMusics $mediasMusic): self
    {
        if (!$this->mediasMusics->contains($mediasMusic)) {
            $this->mediasMusics->add($mediasMusic);
            $mediasMusic->setMedia($this);
        }

        return $this;
    }

    public function removeMediasMusic(MediasMusics $mediasMusic): self
    {
        if ($this->mediasMusics->removeElement($mediasMusic)) {
            // set the owning side to null (unless already changed)
            if ($mediasMusic->getMedia() === $this) {
                $mediasMusic->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MediasVideos>
     */
    public function getMediasVideos(): Collection
    {
        return $this->mediasVideos;
    }

    public function addMediasVideo(MediasVideos $mediasVideo): self
    {
        if (!$this->mediasVideos->contains($mediasVideo)) {
            $this->mediasVideos->add($mediasVideo);
            $mediasVideo->setMedia($this);
        }

        return $this;
    }

    public function removeMediasVideo(MediasVideos $mediasVideo): self
    {
        if ($this->mediasVideos->removeElement($mediasVideo)) {
            // set the owning side to null (unless already changed)
            if ($mediasVideo->getMedia() === $this) {
                $mediasVideo->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
