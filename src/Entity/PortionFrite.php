<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    collectionOperations: ["get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups'=>['burger:read:simple']]
    ],"post"=>[
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        'denormalization_context' => ['groups' => ['write']],
        'normalization_context' => ['groups' => ['burger:read:all']],
        'input_formats' => [
            'multipart' => ['multipart/form-data'],
        ]  
    ]],
    itemOperations: ["put"=> [
        'method' => 'put',
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        'denormalization_context' => ['groups' => ['write']],
        ],"get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups'=>['burger:read:all']]
        ],"delete"=>[
            'method' => 'delete',
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message"=>"Vous n'avez pas access à cette Ressource",
        ]]
)]
class PortionFrite extends Produit
{
    #[Groups(["write","burger:read:simple"])]
    private $complement;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'portionFrites')]
    private $gestionnaire;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'portionFrites')]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: MenuPortionFrite::class)]
    private $menuPortionFrites;

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: PortionFriteCommande::class)]
    private $portionFriteCommandes;

    private ?DetailsProduits $detailsProduits = null;

    public function __construct()
    {
        //parent::__construct();
        $this->menuPortionFrites = new ArrayCollection();
        $this->type = 'portion';
        $this->portionFriteCommandes = new ArrayCollection();
    }
    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, MenuPortionFrite>
     */
    public function getMenuPortionFrites(): Collection
    {
        return $this->menuPortionFrites;
    }

    public function addMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if (!$this->menuPortionFrites->contains($menuPortionFrite)) {
            $this->menuPortionFrites[] = $menuPortionFrite;
            $menuPortionFrite->setPortionFrite($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getPortionFrite() === $this) {
                $menuPortionFrite->setPortionFrite(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PortionFriteCommande>
     */
    public function getPortionFriteCommandes(): Collection
    {
        return $this->portionFriteCommandes;
    }

    public function addPortionFriteCommande(PortionFriteCommande $portionFriteCommande): self
    {
        if (!$this->portionFriteCommandes->contains($portionFriteCommande)) {
            $this->portionFriteCommandes[] = $portionFriteCommande;
            $portionFriteCommande->setPortionFrite($this);
        }

        return $this;
    }

    public function removePortionFriteCommande(PortionFriteCommande $portionFriteCommande): self
    {
        if ($this->portionFriteCommandes->removeElement($portionFriteCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionFriteCommande->getPortionFrite() === $this) {
                $portionFriteCommande->setPortionFrite(null);
            }
        }

        return $this;
    }

    public function getDetailsProduits(): ?DetailsProduits
    {
        return $this->detailsProduits;
    }

    public function setDetailsProduits(?DetailsProduits $detailsProduits): self
    {
        $this->detailsProduits = $detailsProduits;

        return $this;
    }

    
}
