<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"=>[
            'normalization_context' => ['groups'=>['zone:read']],
            "security" => "is_granted('ALL', _api_resource_class)",
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ['zone:write']],
            'normalization_context' => ['groups' => ['zone:read']],
            "security_post_denormalize" => "is_granted('READ', object)",
        ]
        ], itemOperations:[
            "put"=>[
                'denormalization_context' => ['groups' => ['zone:write']],
            'normalization_context' => ['groups' => ['zone:read']],
            "security_post_denormalize" => "is_granted('READ', object)",
            ],
            "get" => [
            "security" => "is_granted('READ', object)",
            ]
        ]
)]
#[UniqueEntity(fields:'libelle',message: 'le libelle doit etre unique!')]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["zone:read","quartier:write","commande:write"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: 'le libelle ne doit pas etre vide')]
    #[Groups(["zone:read","zone:write","commande:read"])]
    private $libelle;

    #[ORM\Column(type: 'integer')]
    #[Groups(["zone:read","zone:write"])]
    #[Assert\NotBlank(message: 'le prix ne doit pas etre vide')]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartiers;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->quartiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }
}
