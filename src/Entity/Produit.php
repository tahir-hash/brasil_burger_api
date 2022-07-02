<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\GraphQl\Resolver\Stage\DeserializeStage;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[UniqueEntity(fields:'nom',message: 'le nom doit etre unique!')]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "burger" => "Burger","menu" => "Menu","boisson" => "Boisson","portion" => "PortionFrite"])]
#[ApiResource]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue","complement"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue","complement"])]
    #[Assert\NotBlank(message: 'le nom ne doit pas etre vide')]
    protected $nom;


    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:simple","burger:read:all","write","catalogue","complement"])]
   // #[Assert\NotBlank(message: 'Le prix ne doit pas etre vide')]
    protected $prix;

    #[ORM\Column(type: 'text')]
    #[Groups(["burger:read:all","write"])]
    #[Assert\NotBlank(message: 'La description ne doit pas etre vide')]
    protected $description;

    #[ORM\Column(type: 'string', length: 255)]
    protected $etat='DISPONIBLE';

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommande::class)]
    private $produitCommandes;

    #[ORM\Column(type: 'blob')]
  //  #[Groups(["burger:read:simple","burger:read:all","write","catalogue"])]
    protected $image;

    protected $imageFile;

    public function __construct()
    {
        $this->produitCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, ProduitCommande>
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes[] = $produitCommande;
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->removeElement($produitCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getImage()
    {
        return base64_encode($this->image);

    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}
