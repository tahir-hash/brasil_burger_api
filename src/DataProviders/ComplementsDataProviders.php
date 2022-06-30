<?php

namespace App\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complement;
use App\Repository\PortionFriteRepository;
use App\Repository\BoissonRepository;

class ComplementsDataProviders implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private PortionFriteRepository $repo;
    private BoissonRepository $reposit;

    public function __construct(PortionFriteRepository $repo, BoissonRepository $reposit)
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
        $complements=[];
        $frites= $this->repo->findby(["etat"=>"DISPONIBLE"]);
        $boissons= $this->reposit->findby(["etat"=>"DISPONIBLE"]);
        foreach ($frites as  $frite)
        {
           $complements[]=$frite;
        }

        foreach ($boissons as $boisson) 
        {
            $complements[]=$boisson;
        }

         return $complements;
    }
}