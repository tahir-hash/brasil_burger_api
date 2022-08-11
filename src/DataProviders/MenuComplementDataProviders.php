<?php

namespace App\DataProviders;
use App\Entity\Burger;
use App\Entity\MenuComplement;
use App\Repository\BurgerRepository;
use App\Repository\TailleRepository;

use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

final class MenuComplementDataProviders implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
   
    public function __construct(TailleRepository $repo, 
    PortionFriteRepository $reposit,
    BurgerRepository $burgerRepository)
    {
        $this->repo = $repo;
        $this->reposit = $reposit;
        $this->burgerRepository = $burgerRepository;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
    
        return MenuComplement::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?MenuComplement
    {
        $menuComplement=new MenuComplement;
        $tailles = $this->repo->findAll();
        $frites = $this->reposit->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"]);
        $burgers = $this->burgerRepository->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"]);
        $menuComplement->tailles=$tailles;
        $menuComplement->burgers=$burgers;
        $menuComplement->frites = $frites;
        return $menuComplement ;
    }
}