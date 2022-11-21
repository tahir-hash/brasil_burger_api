<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"=>[
            'normalization_context' => ['groups' => ['livraison:read:livreur']],
        ],
        "post" => [
            "method" => "POST",
            'denormalization_context' => ['groups' => ['livraison:write']],
            'normalization_context' => ['groups' => ['livraison:read']],
            "security_post_denormalize" => "is_granted('CREATE', object)",
        ]
        ],itemOperations: [
        'get'=>[
            'normalization_context' => ['groups' => ['livraison:read:details']],
        ],
        'put'=>[
            'denormalization_context' => ['groups' => ['livraison:update']],
        ]],
)]
#[ApiFilter(SearchFilter::class, properties: ['etat' => 'exact', 'livreur' => 'exact'])]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['livraison:read:livreur'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["livraison:write",'livraison:read:livreur'])]
    private $montantTotal;
    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups(["livraison:write"])]
    private $livreur;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(["livraison:write","livraison:read:details",'livraison:read:livreur'])]
    private $commandes;

    #[ORM\Column(length: 255)]
    #[Groups(['livraison:update',"livreur:read:details",'livraison:read:livreur'])]
    private string $etat = "EN COURS";

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTotal(): ?int
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(int $montantTotal): self
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
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
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
