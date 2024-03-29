<?php

namespace App\Service;

class CommandePriceService
{

    public function montantCommande($data)
    {
        $total = 0;
        foreach ($data->getBurgerCommandes() as $burger) {
            $prix = $burger->getBurger()->getPrix() * $burger->getQuantite();
            $burger->setPrix($prix);
            $total += $prix;
        }
        foreach ($data->getPortionFriteCommandes() as $frites) {
            $prix = $frites->getPortionFrite()->getPrix() * $frites->getQuantite();
            $frites->setPrix($prix);
            $total += $prix;
        }
        foreach ($data->getBoissonTailleCommandes() as $taille) {
            $prix = $taille->getBoissonTaille()->getTaille()->getPrix() * $taille->getQuantite();
            $stock=$taille->getBoissonTaille()->getStock();
            $quantite=$taille->getQuantite();
            $stock=$stock-$quantite;
            $taille->getBoissonTaille()->setStock($stock);
            $taille->setPrix($prix);
            $total += $prix;
        }
        foreach ($data->getMenuCommandes() as $menu) {
            $prix = $menu->getMenu()->getPrix() * $menu->getQuantite();
            $menu->setPrix($prix);
            foreach ($menu->getMenu()->getCommandeMenuBoissonTailles() as $com) {
                    $stock=$com->getBoissonTaille()->getStock();
                    $quantite=$com->getQuantite();
                    $stock=$stock-$quantite;
                    $com->getBoissonTaille()->setStock($stock);
            }
            $total += $prix;
        }
        if($data->getZone()!=null){
            $total+=$data->getZone()->getPrix();
        }
       // $total+=$data->getZone()->getPrix();
        return $total;
    }
}
