<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeMenuBoissonTailleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeMenuBoissonTailleRepository::class)]
#[ApiResource]
class CommandeMenuBoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read","commande:write"])]
    private $quantite=1;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeMenuBoissonTailles')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'commandeMenuBoissonTailles')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: BoissonTaille::class, inversedBy: 'commandeMenuBoissonTailles')]
    #[Groups(["commande:read","commande:write"])]
    private $boissonTaille;

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

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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
}
