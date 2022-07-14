<?php

namespace App\Security\Voter;

use App\Entity\Commande;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CommandeVoter extends Voter
{
    private $security=null;

    public function __construct(Security $security)
    {   
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        if($attribute== "ALL")
        {
            $subject= new $subject();
        }
        $supportsAttribute = in_array($attribute, ["CREATE", "EDIT", "DELETE", "READ","ALL"]);
        $supportsSubject = $subject instanceof Commande;
        return $supportsAttribute && $supportsSubject;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case "CREATE":
                if($this->security->isGranted('ROLE_CLIENT'))
                {
                    return true;
                }
                break;
            case "ALL":
                if($this->security->isGranted('ROLE_GESTIONNAIRE'))
                {
                    return true;
                }
                break;
        }

        return false;
    }
}
