<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["details:read","write","burger:read:all","burger:read:simple"])]
    #[Assert\GreaterThan(0,message: 'La quantite doit etre superieur à zero')]
    private $quantite=1;


    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    #[Groups(["details:read","write","burger:read:all","burger:read:simple"])]
    #[Assert\NotBlank(message: 'Choisir au moins un burger')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $menu;

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


    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

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
}
