<?php

namespace App\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complement;
use App\Entity\PortionFrite;
use App\Entity\Taille;
use App\Repository\PortionFriteRepository;
use App\Repository\TailleRepository;

class ComplementsDataProviders implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private PortionFriteRepository $repo;
    private TailleRepository $reposit;

    public function __construct(PortionFriteRepository $repo, TailleRepository $reposit)
    {
        $this->repo = $repo;
        $this->reposit = $reposit;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $catalogue=[];
        $burgers= $this->repo->findby(["etat"=>"DISPONIBLE"]);
        $menus= $this->reposit->findby(["etat"=>"DISPONIBLE"]);
        foreach ($burgers as  $burger)
        {
           $catalogue[]=$burger;
        }

        foreach ($menus as $menu) 
        {
            $catalogue[]=$menu;
        }

         return $catalogue;
    }
}
