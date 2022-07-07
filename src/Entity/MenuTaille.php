<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuTailleRepository::class)]
#[ApiResource]
class MenuTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[ORM\Column(type: 'integer')]
    #[Groups(["write","burger:read:all","burger:read:simple"])]
    #[Assert\GreaterThan(0,message: 'La quantite doit etre superieur à zero')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menuTailles')]
    #[Groups(["write","burger:read:all","burger:read:simple","commande:write",  "commande:read"])]
    #[Assert\NotBlank(message: 'Choisir au moins une Taille')]
    private $taille;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuTailles')]
    private $menu;

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
