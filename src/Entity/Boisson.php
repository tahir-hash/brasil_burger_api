<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
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
class Boisson extends Produit
{
    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'boissons',cascade:['persist'])]
    #[Groups(["write","burger:read:all"])]

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'boissons')]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: BoissonTaille::class,cascade:['persist'])]
    #[Groups(["write","burger:read:all"])]
    private $boissonTailles;

    public function __construct()
    {
        $this->boissonTailles = new ArrayCollection();
        $this->type = 'boisson';
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
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setBoisson($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getBoisson() === $this) {
                $boissonTaille->setBoisson(null);
            }
        }

        return $this;
    }
}
