<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Complement::class, mappedBy: 'menus')]
    private $complements;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    private $Burgers;

    #[ORM\ManyToOne(targetEntity: Catalogue::class, inversedBy: 'menus')]
    #[ORM\JoinColumn(nullable: false)]
    private $catalogue;

    public function __construct()
    {
        $this->complements = new ArrayCollection();
        $this->Burgers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Complement>
     */
    public function getComplements(): Collection
    {
        return $this->complements;
    }

    public function addComplement(Complement $complement): self
    {
        if (!$this->complements->contains($complement)) {
            $this->complements[] = $complement;
            $complement->addMenu($this);
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self
    {
        if ($this->complements->removeElement($complement)) {
            $complement->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->Burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->Burgers->contains($burger)) {
            $this->Burgers[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->Burgers->removeElement($burger);

        return $this;
    }

    public function getCatalogue(): ?Catalogue
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    }
}
