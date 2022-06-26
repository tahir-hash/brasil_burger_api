<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Service\ServiceMailer;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserDataPersister implements DataPersisterInterface
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private ServiceMailer $mailer;


    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        ServiceMailer $mailer
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->mailer=$mailer;
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
        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPassword()
        );
        $data->setPassword($hashedPassword);
        $data->setToken($this->generateToken());
        $data->setRoles(["ROLE_CLIENT"]);
        $data->setExpireAt(new \DateTime('+1 minutes'));
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        $this->mailer->sendEmail($data->getLogin(), $data->getToken());
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
