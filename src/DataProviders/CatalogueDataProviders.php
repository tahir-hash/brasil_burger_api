<?php

namespace App\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;

class CatalogueDataProviders implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private BurgerRepository $repo;
    private MenuRepository $reposit;

    public function __construct(BurgerRepository $repo,MenuRepository $reposit)
    {
        $this->repo = $repo;
        $this->reposit = $reposit;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $catalogue=[];
        $burgers= $this->repo->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"]);
        $menus= $this->reposit->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"]);
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