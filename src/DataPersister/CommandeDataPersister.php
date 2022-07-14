<?php

namespace App\DataPersister;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Commande;
use App\Service\CommandePriceService;
use App\Service\NumCmd;

class CommandeDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private CommandePriceService $montant;
    private NumCmd $numcmd;
    public function __construct(
        EntityManagerInterface $entityManager,
        CommandePriceService $montant,
        NumCmd $numcmd
    ) {
        $this->entityManager = $entityManager;
        $this->montant = $montant;
        $this->numcmd = $numcmd;
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
        //dd($data->getMenuCommandes()[0]->getQuantite());
        $prixCmd=$this->montant->montantCommande($data);
        $num= $this->numcmd->NumCmdGenrator();
        $data->setNumCmd($num);
        $data->setMontant($prixCmd);
       // dd($data->getNumCmd());
      //dd($data);
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
