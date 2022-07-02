<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Service\UploadFile;
use App\Service\MenuService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class ProduitDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private MenuService $prix;
    private UploadFile $uploadFile;
    public function __construct(
        EntityManagerInterface $entityManager,
        MenuService $prix,
        UploadFile $uploadFile,
        private RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->prix = $prix;
        $this->uploadFile = $uploadFile;
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
        $blob=$this->uploadFile->encodeImage();
        $data->setImage($blob);
        
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