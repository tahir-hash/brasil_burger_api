<?php

namespace App\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Complement;
use App\Repository\PortionFriteRepository;
use App\Repository\BoissonRepository;

class ComplementsDataProviders implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $complements;

    public function __construct(PortionFriteRepository $repo, BoissonRepository $reposit)
    {
        $this->complements= new Complement($repo,$reposit);
        
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complement::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        return [
            $this->complements->getPortionFrites(),
            $this->complements->getTailles()
        ];
    }
}