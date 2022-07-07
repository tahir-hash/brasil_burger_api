<?php

namespace App\Service;

class CommandePriceService
{

    public function montantCommande($data)
    {
        $total = 0;
        foreach ($data->getBurgerCommandes() as $burger) {
            $prix = $burger->getBurger()->getPrix() * $burger->getQuantite();
            $burger->setPrix($burger->getBurger()->getPrix());
            $total += $prix;
        }
        foreach ($data->getPortionFriteCommandes() as $frites) {
            $prix = $frites->getPortionFrite()->getPrix() * $frites->getQuantite();
            $frites->setPrix($frites->getPortionFrite()->getPrix());
            $total += $prix;
        }
        foreach ($data->getBoissonTailleCommandes() as $taille) {
            $prix = $taille->getBoissonTaille()->getTaille()->getPrix() * $taille->getQuantite();
            $taille->setPrix($taille->getBoissonTaille()->getTaille()->getPrix());
            $total += $prix;
        }

        $total+=$data->getZone()->getPrix();

        return $total;
    }
}
