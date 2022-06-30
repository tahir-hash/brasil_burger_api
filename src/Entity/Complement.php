<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

//#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    collectionOperations: ["get"=>[
        'method' => 'get',
        'normalization_context' => ['groups'=>['complement']]
    ]],itemOperations: [
        
    ]
)]
class Complement
{
    private $id;

    #[ORM\OneToMany(mappedBy: 'complement', targetEntity: PortionFrite::class)]
    #[Groups(["complement"])]
    private $portionFrites;

    #[ORM\OneToMany(mappedBy: 'complement', targetEntity: Taille::class)]
    private $tailles;

    public function __construct(PortionFriteRepository $repo, BoissonRepository $reposit)
    {
        $this->portionFrites = ["frites"=>$repo->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"])];
        $this->tailles =["boissons"=>$reposit->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"])];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   
    public function getPortionFrites()
    {
        return $this->portionFrites;
    }

   
    public function getTailles()
    {
        return $this->tailles;
    }

    
}
