<?php

namespace App\Service;

class MenuService
{

    public function prixMenu($data)
    {
       // $data->getMenuBurgers()[1]->getBurger()->getPrix();
        $total=0;
            foreach ($data->getMenuBurgers() as $burger) {
                $prix=$burger->getBurger()->getPrix()*$burger->getQuantite();
                $total+=$prix;
            }
            foreach ($data->getMenuPortionFrites() as $frites) {
                $prix=$frites->getPortionFrite()->getPrix()*$frites->getQuantite();
                $total+=$prix;
            }
            foreach ($data->getMenuTailles() as $taille) {
                $prix=$taille->getTaille()->getPrix()*$taille->getQuantite();
                $total+=$prix;
            }
            $data->setPrix($total);  
    }
}
