<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Produit;
use App\Service\FileUploader;

class ProduitDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private FileUploader $fileUploader;
    public function __construct(
        EntityManagerInterface $entityManager,
        FileUploader $fileUploader
    ) {
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
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
        dd($data);
        $brochureFileName = $this->fileUploader->upload($data->getImage());
        $data->setImage($brochureFileName);
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
