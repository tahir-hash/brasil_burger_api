<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonTailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
#[ApiResource]
class BoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:write","details:read"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["details:read","write","burger:read:all"])]
    #[Assert\GreaterThan(0,message: 'La quantite doit etre superieur à zero')]
    private $stock;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'boissonTailles',cascade:['persist'])]
    #[Groups(["write","burger:read:all",'commande:read:details'])]
    private $taille;
    
    #[ApiResource()]
    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    #[Groups(["details:read","taille",'commande:read:details'])]
    private $boisson;

    #[ORM\OneToMany(mappedBy: 'boissonTaille', targetEntity: BoissonTailleCommande::class)]
    private $boissonTailleCommandes;

    #[ORM\OneToMany(mappedBy: 'boissonTaille', targetEntity: CommandeMenuBoissonTaille::class)]
    private $commandeMenuBoissonTailles;

    public function __construct()
    {
        $this->boissonTailleCommandes = new ArrayCollection();
        $this->commandeMenuBoissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
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

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    /**
     * @return Collection<int, BoissonTailleCommande>
     */
    public function getBoissonTailleCommandes(): Collection
    {
        return $this->boissonTailleCommandes;
    }

    public function addBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if (!$this->boissonTailleCommandes->contains($boissonTailleCommande)) {
            $this->boissonTailleCommandes[] = $boissonTailleCommande;
            $boissonTailleCommande->setBoissonTaille($this);
        }

        return $this;
    }

    public function removeBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if ($this->boissonTailleCommandes->removeElement($boissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleCommande->getBoissonTaille() === $this) {
                $boissonTailleCommande->setBoissonTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeMenuBoissonTaille>
     */
    public function getCommandeMenuBoissonTailles(): Collection
    {
        return $this->commandeMenuBoissonTailles;
    }

    public function addCommandeMenuBoissonTaille(CommandeMenuBoissonTaille $commandeMenuBoissonTaille): self
    {
        if (!$this->commandeMenuBoissonTailles->contains($commandeMenuBoissonTaille)) {
            $this->commandeMenuBoissonTailles[] = $commandeMenuBoissonTaille;
            $commandeMenuBoissonTaille->setBoissonTaille($this);
        }

        return $this;
    }

    public function removeCommandeMenuBoissonTaille(CommandeMenuBoissonTaille $commandeMenuBoissonTaille): self
    {
        if ($this->commandeMenuBoissonTailles->removeElement($commandeMenuBoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenuBoissonTaille->getBoissonTaille() === $this) {
                $commandeMenuBoissonTaille->setBoissonTaille(null);
            }
        }

        return $this;
    }
}
