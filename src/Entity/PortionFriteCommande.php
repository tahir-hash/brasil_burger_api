<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionFriteCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PortionFriteCommandeRepository::class)]
#[ApiResource]
class PortionFriteCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read","commande:write"])]

    private $quantite;

    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'portionFriteCommandes')]
    #[Groups(["commande:read","commande:write"])]
    private $portionFrite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'portionFriteCommandes')]
    private $commande;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPortionFrite(): ?PortionFrite
    {
        return $this->portionFrite;
    }

    public function setPortionFrite(?PortionFrite $portionFrite): self
    {
        $this->portionFrite = $portionFrite;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
