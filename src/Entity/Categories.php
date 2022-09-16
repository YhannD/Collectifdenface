<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255/*, unique: true*/)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Medias::class, mappedBy: 'categories')]
    private Collection $medias;

    public function __construct()
    {
        $this->medias = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    /**
     * @return Collection<int, Medias>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Medias $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->addCategory($this);
        }

        return $this;
    }

    public function removeMedia(Medias $media): self
    {
        if ($this->medias->removeElement($media)) {
            $media->removeCategory($this);
        }

        return $this;
    }
}
