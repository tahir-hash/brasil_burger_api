<?php

namespace App\Service;

use App\Entity\Menu;
use Symfony\Component\Validator\Context\ExecutionContext;

class ValidationService
{
    public function isMenuValid(ExecutionContext $context, Menu $menu)
    {
        $portion=count($menu->getMenuPortionFrites());
        $talles=count($menu->getMenuTailles());
        if ($portion==0 && $talles==0) 
        {
            $context->buildViolation("Le menu doit avoir au moins un complement!!")
            ->addViolation();
        }
    }
    public function test(ExecutionContext $context, Menu $menu)
    {
        $array = [];
        foreach ($menu->getMenuBurgers() as  $burger) {
            $array[] = $burger->getBurger();
        }
        //dd($array);
        $notDoub = array_unique($array, SORT_REGULAR);
        if (count($menu->getMenuBurgers()) != count($notDoub)) {
            $context->buildViolation("Vous avez ajouter deux burgers identiques")
            ->addViolation();
        }
    }
}