<?php

namespace App\DataPersister;

use App\Service\NumCmd;
use App\Entity\Commande;
use App\Service\CommandePriceService;
use App\Service\ValidationCommande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\HttpFoundation\Request;

class CommandeDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private CommandePriceService $montant;
    private NumCmd $numcmd;
    private ValidationCommande $valid;
    public function __construct(
        EntityManagerInterface $entityManager,
        CommandePriceService $montant,
        NumCmd $numcmd,
        ValidationCommande $valid,
    ) {
        $this->entityManager = $entityManager;
        $this->montant = $montant;
        $this->numcmd = $numcmd;
        $this->valid = $valid;
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
        //dd($data->getZone());
        $prixCmd=$this->montant->montantCommande($data);
        $num= $this->numcmd->NumCmdGenrator();
        $data->setNumCmd($num);
        $data->setMontant($prixCmd);
        foreach ($data->getMenuCommandes() as $commande) {
           foreach ($commande->getMenu()->getCommandeMenuBoissonTailles() as $cmd1) {
            $cmd1->setCommande($data);
           }
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
