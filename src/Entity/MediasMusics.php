<?php

namespace App\Entity;

use App\Repository\MediasMusicsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediasMusicsRepository::class)]
class MediasMusics
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'mediasMusics')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medias $media = null;

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

    public function getMedia(): ?Medias
    {
        return $this->media;
    }

    public function setMedia(?Medias $media): self
    {
        $this->media = $media;

        return $this;
    }
}
