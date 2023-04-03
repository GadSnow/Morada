<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CityRepository::class)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cityName = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    private ?Region $region = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Quarter::class)]
    private Collection $quarters;

    public function __construct()
    {
        $this->quarters = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection<int, Quarter>
     */
    public function getQuarters(): Collection
    {
        return $this->quarters;
    }

    public function addQuarter(Quarter $quarter): self
    {
        if (!$this->quarters->contains($quarter)) {
            $this->quarters->add($quarter);
            $quarter->setCity($this);
        }

        return $this;
    }

    public function removeQuarter(Quarter $quarter): self
    {
        if ($this->quarters->removeElement($quarter)) {
            // set the owning side to null (unless already changed)
            if ($quarter->getCity() === $this) {
                $quarter->setCity(null);
            }
        }

        return $this;
    }
}
