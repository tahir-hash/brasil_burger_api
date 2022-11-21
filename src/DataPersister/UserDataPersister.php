<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Service\ServiceMailer;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Client;
use App\Service\PasswordHasher;

class UserDataPersister implements DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private ServiceMailer $mailer;
    private PasswordHasher $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        ServiceMailer $mailer,
        PasswordHasher $passwordHasher
    ) {
        $this->entityManager = $entityManager;
        $this->mailer=$mailer;
        $this->passwordHasher=$passwordHasher;
    }
    public function supports($data): bool
    {
        return $data instanceof User;
    }
    /**
     * @param User $data
     */
    public function persist($data)
    {
        $this->passwordHasher->hasher($data);
        if($data instanceof  Client)
        {
            $data->setRoles(["ROLE_CLIENT"]);
            $data->setExpireAt(new \DateTime('+1 minutes'));
            $data->setToken($this->generateToken());
            $this->mailer->sendEmail($data->getLogin(), $data->getToken());
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

}
