<?php

namespace App\Entity;

use App\Repository\ExhibitionYearRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExhibitionYearRepository::class)]
class ExhibitionsYears
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4)]
    private ?string $year = null;

    #[ORM\OneToMany(mappedBy: 'exhibitionsYears', targetEntity: Exhibitions::class, orphanRemoval: true)]
    private Collection $exhibitions;

    public function __construct()
    {
        $this->exhibitions = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->year;
    }
    public function getId(): ?string
    {
        return $this->id;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, Exhibitions>
     */
    public function getExhibitions(): Collection
    {
        return $this->exhibitions;
    }

    public function addExhibition(Exhibitions $exhibition): self
    {
        if (!$this->exhibitions->contains($exhibition)) {
            $this->exhibitions->add($exhibition);
            $exhibition->setExhibitionsYears($this);
        }

        return $this;
    }

    public function removeExhibition(Exhibitions $exhibition): self
    {
        if ($this->exhibitions->removeElement($exhibition)) {
            // set the owning side to null (unless already changed)
            if ($exhibition->getExhibitionsYears() === $this) {
                $exhibition->setExhibitionsYears(null);
            }
        }

        return $this;
    }
}
