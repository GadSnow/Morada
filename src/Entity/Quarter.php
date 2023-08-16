<?php

namespace App\Entity;

use App\Repository\QuarterRepository;
use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: QuarterRepository::class)]
#[Vich\Uploadable]
class Quarter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $quarterName = null;

    #[ORM\Column]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'quarter', targetEntity: Housing::class)]
    private Collection $housings;

    #[ORM\ManyToOne(inversedBy: 'quarters')]
    private ?City $city = null;

    #[Vich\UploadableField(mapping: 'quarters_image', fileNameProperty: 'filename')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $filename = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->housings = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuarterName(): ?string
    {
        return $this->quarterName;
    }

    public function setQuarterName(string $quarterName): self
    {
        $this->quarterName = $quarterName;

        return $this;
    }

    public function getSlug()
    {
        return (new Slugify())->slugify($this->quarterName);
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Housing>
     */
    public function getHousings(): Collection
    {
        return $this->housings;
    }

    public function addHousing(Housing $housing): self
    {
        if (!$this->housings->contains($housing)) {
            $this->housings->add($housing);
            $housing->setQuarter($this);
        }

        return $this;
    }

    public function removeHousing(Housing $housing): self
    {
        if ($this->housings->removeElement($housing)) {
            // set the owning side to null (unless already changed)
            if ($housing->getQuarter() === $this) {
                $housing->setQuarter(null);
            }
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return 
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param  $imageFile 
     * @return self
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return 
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param  $filename 
     * @return self
     */
    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return 
     */
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param  $updatedAt 
     * @return self
     */
    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
