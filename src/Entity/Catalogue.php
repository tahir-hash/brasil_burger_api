<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CatalogueRepository::class)]
#[ApiResource]
class Catalogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'catalogue', targetEntity: Menu::class)]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'catalogue', targetEntity: Burger::class)]
    private $burgers;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->burgers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setCatalogue($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getCatalogue() === $this) {
                $menu->setCatalogue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->setCatalogue($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getCatalogue() === $this) {
                $burger->setCatalogue(null);
            }
        }

        return $this;
    }
}
