<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(collectionOperations: [
    "get"=>[
        'normalization_context' => ['groups' => ['livreur:read']],
    ],
    "post" => [
        "method" => "post",
        'normalization_context' => ['groups' => ['livreur:read']],
    ]
], itemOperations: [
    "get" => [
        'normalization_context' => ['groups' => ['livreur:read']],
    ],
    "put"=>[
        "method" => 'put',
        'normalization_context' => ['groups' => ['livreur:read']]
    ]
])]
#[UniqueEntity(fields: 'matriculeMoto', message: 'le matricule doit etre unique!')]
class Livreur extends User
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livreur:read"])]
    private $matriculeMoto;

    #[ORM\Column(type: 'integer')]
    #[Groups(["livreur:read"])]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livreur:read"])]
    private $etat = "DISPONIBLE";

    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
        $this->roles = ['ROLE_LIVREUR'];
    }

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

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
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }
}
