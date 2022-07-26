<?php

namespace App\Service;

use App\Entity\Commande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Context\ExecutionContext;

class ValidationCommande 
{
    private RequestStack $request;
    public function __construct(RequestStack $request,)
    {
       $this->request = $request;
    }
    public function valid(ExecutionContext $context)
    {
        if($this->request->getCurrentRequest()->isMethod('POST'))
        {
            dd('ok');
            /* if (count($this->commande->getBurgerCommandes()) == 0 && count($this->commande->getMenuCommandes()) == 0) {
                $context->buildViolation("Une commande doit avoir au moins un burger ou un menu")
                    ->addViolation();
            } */
        }
    }
}