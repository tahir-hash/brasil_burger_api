<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\ValidationCommande;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContext;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    attributes: ["pagination_enabled" => false],
    collectionOperations: [
        "get" => [
            'normalization_context' => ['groups' => ['commande:read']],
            "security" => "is_granted('ALL', _api_resource_class)",
        ],
        "post" => [
            "method" => "POST",
            'denormalization_context' => ['groups' => ['commande:write']],
            'normalization_context' => ['groups' => ['commande:read']],
            "security_post_denormalize" => "is_granted('CREATE', object)",
        ]
    ]
)]

class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:read', "livraison:write","user:read:item","livraison:read:details"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['commande:read', "commande:write", "user:read:item","livraison:read:details"])]
    private $numCmd;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['commande:read', "user:read:item","livraison:read:details",'commande:write'])]
    private $dateCmd;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:read', "user:read:item","livraison:read:details"])]
    private $montant;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['commande:read', "commande:update", "user:read:item","livraison:read:details"])]
    private $etat = "EN COURS";

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: true)]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private $client;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commande:read', "commande:write","livraison:read:details"])]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BurgerCommande::class, cascade: ['persist'])]
    #[Groups(["commande:write"])]
    #[Assert\Valid]
    private $burgerCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: MenuCommande::class, cascade: ['persist'])]
    #[Groups(["commande:write"])]
    #[Assert\Valid]
    private $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: PortionFriteCommande::class, cascade: ['persist'])]
    #[Groups(["commande:write"])]
    #[Assert\Valid]
    private $portionFriteCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BoissonTailleCommande::class, cascade: ['persist'])]
    #[Groups(["commande:write"])]
    #[Assert\Valid]
    private $boissonTailleCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeMenuBoissonTaille::class)]
    private $commandeMenuBoissonTailles;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["commande:write"])]
    private ?string $telClient = null;


    public function __construct()
    {
        $this->dateCmd = new \DateTime();
        $this->burgerCommandes = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->portionFriteCommandes = new ArrayCollection();
        $this->boissonTailleCommandes = new ArrayCollection();
        $this->commandeMenuBoissonTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumCmd(): ?string
    {
        return $this->numCmd;
    }

    public function setNumCmd(string $numCmd): self
    {
        $this->numCmd = $numCmd;

        return $this;
    }

    public function getDateCmd(): ?\DateTimeInterface
    {
        return $this->dateCmd;
    }

    public function setDateCmd(\DateTimeInterface $dateCmd): self
    {
        $this->dateCmd = $dateCmd;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection
    {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getCommande() === $this) {
                $burgerCommande->setCommande(null);
            }
        }

        return $this;
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
            $menuCommande->setCommande($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getCommande() === $this) {
                $menuCommande->setCommande(null);
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
            $portionFriteCommande->setCommande($this);
        }

        return $this;
    }

    public function removePortionFriteCommande(PortionFriteCommande $portionFriteCommande): self
    {
        if ($this->portionFriteCommandes->removeElement($portionFriteCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionFriteCommande->getCommande() === $this) {
                $portionFriteCommande->setCommande(null);
            }
        }

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
            $boissonTailleCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBoissonTailleCommande(BoissonTailleCommande $boissonTailleCommande): self
    {
        if ($this->boissonTailleCommandes->removeElement($boissonTailleCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonTailleCommande->getCommande() === $this) {
                $boissonTailleCommande->setCommande(null);
            }
        }

        return $this;
    }
    // #[Assert\Callback]
    public function valid(ExecutionContext $context)
    {
        if (count($this->getBurgerCommandes()) == 0 && count($this->getMenuCommandes()) == 0) {
            $context->buildViolation("Une commande doit avoir au moins un burger ou un menu")
                ->addViolation();
        }
    }

    //#[Assert\Callback]
    public function menuBoisson(ExecutionContext $context)
    {
        foreach ($this->getMenuCommandes() as $menu) {
            $count = count($menu->getMenu()->getMenuTailles());

            foreach ($menu->getMenu()->getMenuTailles() as $menuTailles) {
                $taille = $menuTailles->getTaille()->getId();
                $qte = $menuTailles->getQuantite();
                $cpt = 0;
                foreach ($menu->getMenu()->getCommandeMenuBoissonTailles() as $commande) {
                    $tailleBoisson = $commande->getBoissonTaille()->getTaille()->getId();
                    $arr[] = $tailleBoisson;
                    $objTaille[] = $commande->getBoissonTaille()->getTaille();
                    if ($taille == $tailleBoisson) {
                        $cpt += $commande->getQuantite();
                    }
                }

                $count1 = count(array_unique($objTaille, SORT_REGULAR));

                if ($count != $count1) {
                    $context->buildViolation("menu bakhoul")
                        ->addViolation();
                }
                if (!in_array($taille, $arr)) {
                    $context->buildViolation("menu taille")
                        ->addViolation();
                }
                if ($cpt != $qte) {
                    $context->buildViolation("menu quantite")
                        ->addViolation();
                }
            }
            ///////////////////////////////////////
            foreach ($menu->getMenu()->getCommandeMenuBoissonTailles() as $com) {
                $stock = $com->getBoissonTaille()->getStock();
                $quantite = $com->getQuantite() * $menu->getQuantite();
                if ($quantite > $stock) {
                    $context->buildViolation("rupture")
                        ->addViolation();
                }
            }
        }
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
            $commandeMenuBoissonTaille->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeMenuBoissonTaille(CommandeMenuBoissonTaille $commandeMenuBoissonTaille): self
    {
        if ($this->commandeMenuBoissonTailles->removeElement($commandeMenuBoissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenuBoissonTaille->getCommande() === $this) {
                $commandeMenuBoissonTaille->setCommande($this);
            }
        }

        return $this;
    }

    public function getTelClient(): ?string
    {
        return $this->telClient;
    }

    public function setTelClient(?string $telClient): self
    {
        $this->telClient = $telClient;

        return $this;
    }
}
