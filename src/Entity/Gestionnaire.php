<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpParser\ErrorHandler\Collecting;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\GraphQl\Resolver\Factory\CollectionResolverFactory;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource]
class Gestionnaire extends User
{

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Burger::class)]
    #[ApiSubresource]
    private $burgers;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->burgers = new ArrayCollection();
       // $this->roles=['ROLE_GESTIONNAIRE'];
    }


    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setGestionnaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getGestionnaire() === $this) {
                $commande->setGestionnaire(null);
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
            $burger->setGestionnaire($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getGestionnaire() === $this) {
                $burger->setGestionnaire(null);
            }
        }

        return $this;
    }
}
