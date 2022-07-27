<?php

namespace App\DataProviders;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Catalogue;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;

class CatalogueDataProviders implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $catalogue;
    public function __construct(BurgerRepository $repo,MenuRepository $reposit)
    {
        $this->catalogue= new Catalogue($repo,$reposit);
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catalogue::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        /* $catalogue=[];
        $catalogue['burgers']= $this->catalogue->getBurgers();
        $catalogue['menus']= $this->catalogue->getMenus(); */
        return [
            $this->catalogue->getBurgers(),
            $this->catalogue->getMenus()
        ];
    }
}