<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
//use App\Entity\Trait\SlugTrait;
use App\Entity\Trait\SlugTrait;
use App\Repository\ExhibitionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExhibitionsRepository::class)]
class Exhibitions
{
    use CreatedAtTrait;
    use SlugTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\OneToMany(mappedBy: 'exhibition', targetEntity: ExhibitionsImages::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $exhibitionsImages;

    public function __construct()
    {
        $this->exhibitionsImages = new ArrayCollection();
        $this->created_at = new \DateTimeImmutable();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, ExhibitionsImages>
     */
    public function getExhibitionsImages(): Collection
    {
        return $this->exhibitionsImages;
    }

    public function addExhibitionsImage(ExhibitionsImages $exhibitionsImage): self
    {
        if (!$this->exhibitionsImages->contains($exhibitionsImage)) {
            $this->exhibitionsImages->add($exhibitionsImage);
            $exhibitionsImage->setExhibition($this);
        }

        return $this;
    }

    public function removeExhibitionsImage(ExhibitionsImages $exhibitionsImage): self
    {
        if ($this->exhibitionsImages->removeElement($exhibitionsImage)) {
            // set the owning side to null (unless already changed)
            if ($exhibitionsImage->getExhibition() === $this) {
                $exhibitionsImage->setExhibition(null);
            }
        }

        return $this;
    }
}
