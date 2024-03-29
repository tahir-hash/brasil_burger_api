<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\MailerController;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    attributes: ["pagination_enabled" => false],
    collectionOperations:[
    "get"=>[
        'method' => 'get',
        'path'=>'/confirmer-mon-compte/{token}',
        'controller'=> MailerController::class,
        ],
    "post_register" => [
        "method"=>"post",
        'path'=>'/register',
        'normalization_context' => ['groups' => ['user:read:simple']],
    ],"mailActived"=>[
        "method"=>"get",
        "path"=>"/confirmer-mon-compte/{token}",
        "controller"=> MailerController::class,
       // "deserialize"=>false
    ]
    ], itemOperations:[
        "get"=>[
        'normalization_context' => ['groups' => ['user:read:item']],
        ]
        ])]
class Client extends User
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["user:read:simple"])]
    private $adresse;

    #[ORM\Column(type: 'integer')]
    #[Groups(["user:read:simple"])]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[ApiSubresource()]
    #[Groups(["user:read:item"])]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        //$this->roles=['ROLE_CLIENT'];
    }
    
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
