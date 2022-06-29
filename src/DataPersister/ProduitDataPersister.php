<?php

namespace App\DataPersister;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class ProduitDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
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
        $file = $data->getImage();
        dd($data);
        $data->setImage($file);
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
