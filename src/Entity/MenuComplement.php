<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    itemOperations: [
        "get"=>[
            'normalization_context' => ['groups' => ['menu:complement:read']],
            ]
    ]
)]
class MenuComplement
{
    public ?int $id=1 ;
    #[Groups(["menu:complement:read"])]
    public array $burgers ;
    #[Groups(["menu:complement:read"])]
    public array $tailles;
    #[Groups(["menu:complement:read"])]
    public array $frites;


    public function __construct()
    {
       
    }

   

    
}
