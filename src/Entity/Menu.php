<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
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
        'normalization_context' => ['groups' => ['burger:read:all']],
        'input_formats' => [
            'multipart' => ['multipart/form-data'],
        ]
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

class Menu extends Produit
{

    #[Groups(["write","burger:read:simple"])]
    private $catalogue;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menus')]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[Groups(["write","burger:read:all","burger:read:simple"])]
    #[Assert\Count(min:1,minMessage: 'Le menu doit contenir au moins 1 burgers')]
    #[Assert\Valid]   
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class,cascade:['persist'])]
    #[Groups(["write","burger:read:all","burger:read:simple"])]
    #[Assert\Valid]
    private $menuTailles;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortionFrite::class,cascade:['persist'])]
    #[Groups(["write","burger:read:all","burger:read:simple"])]
    #[Assert\Valid]   
    private $menuPortionFrites;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuCommande::class)]
    private $menuCommandes;


    public function __construct()
    {
        $this->menuBurgers = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->menuPortionFrites = new ArrayCollection();
        $this->type='menu';
        $this->menuCommandes = new ArrayCollection();
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
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getMenu() === $this) {
                $menuTaille->setMenu(null);
            }
        }

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
            $menuPortionFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuPortionFrite(MenuPortionFrite $menuPortionFrite): self
    {
        if ($this->menuPortionFrites->removeElement($menuPortionFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuPortionFrite->getMenu() === $this) {
                $menuPortionFrite->setMenu(null);
            }
        }

        return $this;
    }

    #[Assert\Callback]
    public function isMenuValid(ExecutionContext $context)
    {
        $portion=count($this->getMenuPortionFrites());
        $talles=count($this->getMenuTailles());
        if ($portion==0 && $talles==0) 
        {
            $context->buildViolation("Le menu doit avoir au moins un complement!!")
            ->addViolation();
        }
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection
    {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self
    {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setMenu($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getMenu() === $this) {
                $menuCommande->setMenu(null);
            }
        }

        return $this;
    }

}
