<?php

namespace App\Service;

class NumCmd
{
    public function NumCmdGenrator()
    {
        $date= date('d-m-Y-h-m-s');
        return "brazil".$date;
    }
}
