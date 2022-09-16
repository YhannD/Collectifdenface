<?php

namespace App\Entity;

use App\Repository\ExhibitionsImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExhibitionsImagesRepository::class)]
class ExhibitionsImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'exhibitionsImages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exhibitions $exhibition = null;

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

    public function getExhibition(): ?Exhibitions
    {
        return $this->exhibition;
    }

    public function setExhibition(?Exhibitions $exhibition): self
    {
        $this->exhibition = $exhibition;

        return $this;
    }
}
