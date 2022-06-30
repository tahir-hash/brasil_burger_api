<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

//#[ORM\Entity(repositoryClass: CatalogueRepository::class)]
#[ApiResource(
    collectionOperations: ["get"=>[
        'method' => 'get',
        'normalization_context' => ['groups'=>['catalogue']]
    ]],itemOperations: [
        
        ]
)]
class Catalogue
{
    #[Groups(["write","burger:read:simple"])]
    private $id;

    #[ORM\OneToMany(mappedBy: 'catalogue', targetEntity: Menu::class)]
    #[Groups(["catalogue"])]
    private $menus;

    #[ORM\OneToMany(mappedBy: 'catalogue', targetEntity: Burger::class)]
   // #[ApiSubresource]
   #[Groups(["catalogue"])]
    private $burgers;

    public function __construct(BurgerRepository $repo, MenuRepository $reposit)
    {
        $this->burgers = ["burgers"=>$repo->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"])];
        $this->menus = ["menus"=>$reposit->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"])];
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getMenus()
    {
        return $this->menus;
    }

    public function getBurgers()
    {
        return $this->burgers;
    }

}
