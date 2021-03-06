<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    itemOperations: [
        "get"=>[
            'normalization_context' => ['groups' => ['details:read']],
            ]
    ]
)]
class DetailsProduits
{
    public ?int $id=1 ;
    #[Groups(["details:read"])]
    public ?Menu $menu ;
    #[Groups(["details:read"])]
    public ?Burger $burger ;
    #[Groups(["details:read"])]
    public array $boissons;
    #[Groups(["details:read"])]
    public array $frites;


    public function __construct()
    {
       
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    
}
