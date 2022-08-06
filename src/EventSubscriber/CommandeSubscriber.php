<?php

namespace App\EventSubscriber;

use App\Entity\Commande;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CommandeSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            //CheckPassportEvent::class => 'onCheckPassport'
        ];
    }
    public function postPersist(LifecycleEventArgs $args)
    {
       $entity = $args->getObjectManager();
       dd($args->getObject()->getCommandeMenuBoissonTailles());
    }

    
}