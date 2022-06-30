<?php

namespace App\DataPersister;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Menu;
use App\Service\MenuService;

class ProduitDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
   private MenuService $prix;
    public function __construct(
        EntityManagerInterface $entityManager,
        MenuService $prix
    ) {
        $this->entityManager = $entityManager;
        $this->prix = $prix;
    }
    public function supports($data): bool
    {
        return $data instanceof Produit;
    }
    /**
     * @param Produit $data
     */
    public function persist($data)
    {
        if($data instanceof Menu)
        {
            $this->prix->prixMenu($data);
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $data->setEtat("ARCHIVER");
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}