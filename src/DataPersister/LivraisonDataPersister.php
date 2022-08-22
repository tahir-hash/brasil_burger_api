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
    public function persist($data, array $context=[])
    {
        if($context['collection_operation_name']=='post'){
            $montantLiv=$this->montant->montantLiv($data);
            $data->setMontantTotal($montantLiv);
            foreach ($data->getCommandes() as $commandes) {
               $commandes->setEtat("EN LIVRAISON");
            }
        $data->getLivreur()->setEtat("INDISPONIBLE");
        }
        if($context['item_operation_name']=='put'){   
          foreach($context['previous_data']->getCommandes() as $cmd){
            $cmd->setEtat("VALIDEE");
          }
         $data->getLivreur()->setEtat("DISPONIBLE");
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
