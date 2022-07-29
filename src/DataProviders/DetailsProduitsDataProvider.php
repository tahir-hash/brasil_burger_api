<?php

namespace App\DataProviders;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\DetailsProduits;
use App\Entity\Menu;
use App\Entity\Burger;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use App\Repository\ProduitRepository;

final class DetailsProduitsDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
   
    public function __construct(BoissonRepository $repo, PortionFriteRepository $reposit,ProduitRepository $prod)
    {
        $this->repo = $repo;
        $this->reposit = $reposit;
        $this->prod = $prod;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
    
        return DetailsProduits::class === $resourceClass;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?DetailsProduits
    {
        $produits= $this->prod->findOneBy(['id'=>$id]);
        $boissons = $this->repo->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"]);
        $frites = $this->reposit->findby(["etat"=>"DISPONIBLE"],['id'=>"desc"]);
        $details= new DetailsProduits();
        $details->boissons = $boissons;
        $details->frites = $frites;
        if($produits instanceof Burger)
        {
           // dd('ok');
            $details->burger = $produits;
        }
        elseif($produits instanceof Menu)
        {
           // dd('menu');
            $details->menu =$produits;
        }
        else{
          //  dd('douma menu ni burger');
            return null;
        }
       // dd($produits instanceof Menu);
       //dd($details);
        return $details;
    }
}