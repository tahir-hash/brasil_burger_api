<?php

namespace App\DataPersister;

use App\Entity\Livraison;
use App\Service\MontantLivraison;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class LivraisonDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private MontantLivraison $montant;
    public function __construct(
        EntityManagerInterface $entityManager,
        MontantLivraison $montant
    ) {
        $this->entityManager = $entityManager;
        $this->montant = $montant;
    }
    public function supports($data): bool
    {
        return $data instanceof Livraison;
    }
    /**
     * @param Livraison $data
     */
    public function persist($data)
    {
        $montantLiv=$this->montant->montantLiv($data);
        $data->setMontantTotal($montantLiv);
       // dd($data);
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
