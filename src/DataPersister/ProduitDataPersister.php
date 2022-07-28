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
        $this->requestStack = $requestStack;
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
        //dd($data);
       // dd($data->getMenuBurgers());
        $request = $this->requestStack->getCurrentRequest();
        if (!empty($request->files->all())) 
        {
            //dd('magui guiss');
            $blob = $this->uploadFile->encodeImage();
            $data->setImage($blob);
        }
            //dd($data);
        if ($data instanceof Menu) {
            $this->prix->prixMenu($data);
           // dd($data->getMenuPortionFrites()[0]->getPortionFrite());
           //dd($data->getPrix());
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        //$data->setEtat("ARCHIVER");
        //$this->entityManager->persist($data);
        $this->entityManager->remove($data);

        $this->entityManager->flush();
    }
}

