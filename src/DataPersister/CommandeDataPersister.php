<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Commande;
use App\Service\CommandePriceService;

class CommandeDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private CommandePriceService $montant;
    public function __construct(
        EntityManagerInterface $entityManager,
        CommandePriceService $montant
    ) {
        $this->entityManager = $entityManager;
        $this->montant = $montant;
    }
    public function supports($data): bool
    {
        return $data instanceof Commande;
    }
    /**
     * @param Commande $data
     */
    public function persist($data)
    {
        dd($data);
        $prixCmd=$this->montant->montantCommande($data);
        $data->setMontant($prixCmd);
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
