<?php

namespace App\DataProviders;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\SubresourceDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\Livreur;

class LivreurDataProviders implements SubresourceDataProviderInterface, RestrictedDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Livreur::class === $resourceClass;
    }
    
    public function getSubresource(string $resourceClass, array $identifiers, array $context, string $operationName = null)
    {
        dd('ok');
        // Retrieve the blog post collection from somewhere
        $blogPosts = $this->subresourceDataProvider->getSubresource($resourceClass, $identifiers, $context, $operationName);
        dd($blogPosts);
        // write your own logic

    }
}