<?php

namespace App\Service;


use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHasher
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
    ) {
        $this->passwordHasher = $passwordHasher;
    }

    public function hasher($data)
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPlainPassword()
        );
        $data->setPassword($hashedPassword);
    }
}
