<?php

namespace App\Service;

class MontantLivraison
{

    public function montantLiv($data)
    {
        $montant=0;
        foreach ($data->getCommandes() as $key => $commande) {
            $montant+=$commande->getMontant();
        }
        return $montant;
    }
       
}

