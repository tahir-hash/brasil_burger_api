<?php

namespace App\EventSubscriber;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\Produit;
use Doctrine\ORM\Events;
use App\Entity\PortionFrite;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            //CheckPassportEvent::class => 'onCheckPassport'
        ];
    }
    
    
    private function getUser()
    {
        //dd($this->token);
        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }
        return $user;
    }
    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getObject() instanceof Produit) {
            $args->getObject()->setGestionnaire($this->getUser());
        }

        if ($args->getObject() instanceof Commande) {
            $args->getObject()->setClient($this->getUser());
        }

        /* if ($args->getObject() instanceof Livraison) {
            $args->getObject()->getCommandes
        } */

    }
    /* public function onCheckPassport(CheckPassportEvent $event)
    {
        $passport = $event->getPassport();
        $user = $passport->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }
        if (!$user->isIsEnabled()) {
            throw new CustomUserMessageAuthenticationException(
                'Please verify your account before logging in.'
            );
        }
    } */
    
}