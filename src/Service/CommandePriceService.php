<?php

namespace App\Service;

class CommandePriceService
{

    public function montantCommande($data)
    {
        $total = 0;
        foreach ($data->getBurgerCommandes() as $burger) {
            $prix = $burger->getBurger()->getPrix() * $burger->getQuantite();
            $total += $prix;
        }
        foreach ($data->getPortionFriteCommandes() as $frites) {
            $prix = $frites->getPortionFrite()->getPrix() * $frites->getQuantite();
            $total += $prix;
        }
        foreach ($data->getBoissonTailleCommandes() as $taille) {
            $prix = $taille->getBoissonTaille()->getTaille()->getPrix() * $taille->getQuantite();
            $total += $prix;
        }

        return $total;
    }
}
