<?php

namespace App\Entity;

use App\Repository\AttractionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttractionRepository::class)]
class Attraction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $shortDescription;

    #[ORM\Column(type: 'text', nullable: true)]
    private $fullDescription;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $score;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updatedAt;

    /**
     * @param $name
     * @param $shortDescription
     * @param $fullDescription
     * @param $score
     */
    public function __construct($name, $shortDescription, $fullDescription, $score)
    {
        $this->name = $name;
        $this->shortDescription = $shortDescription;
        $this->fullDescription = $fullDescription;
        $this->score = $score;
        $this->createAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->fullDescription;
    }

    public function setFullDescription(?string $fullDescription): self
    {
        $this->fullDescription = $fullDescription;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getCreateAt(): ?DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
