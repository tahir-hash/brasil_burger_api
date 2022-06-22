<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource]
class PortionFrite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Complement::class, inversedBy: 'portionFrites')]
    #[ORM\JoinColumn(nullable: false)]
    private $complement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComplement(): ?Complement
    {
        return $this->complement;
    }

    public function setComplement(?Complement $complement): self
    {
        $this->complement = $complement;

        return $this;
    }
}
