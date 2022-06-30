<?php

namespace App\Service;

class MenuService
{

    public function prixMenu($data)
    {
        $total=0;
            foreach ($data->getBurgers() as $burger) {
                $total += $burger->getPrix();
            }
            foreach ($data->getPortionFrites() as $frites) {
                $total += $frites->getPrix();
            }
            foreach ($data->getTailles() as $tailles) {
                $total += $tailles->getPrix();
            }
           // dd($total);
            $data->setPrix($total);  
    }
}
