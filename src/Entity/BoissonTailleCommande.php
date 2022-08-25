<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonTailleCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonTailleCommandeRepository::class)]
#[ApiResource]
class BoissonTailleCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:write",'commande:read:details'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:write",'commande:read:details'])]
    #[Assert\GreaterThan(0,message: 'La quantite doit etre superieur à zero')]
    private $quantite;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:read:details'])]
    private $prix;

    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'boissonTailleCommandes')]
    #[Groups(["commande:write",'commande:read:details'])]
    private $boissonTaille;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'boissonTailleCommandes')]
    private $commande;

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

    public function getBoissonTaille(): ?BoissonTaille
    {
        return $this->boissonTaille;
    }

    public function setBoissonTaille(?BoissonTaille $boissonTaille): self
    {
        $this->boissonTaille = $boissonTaille;

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
