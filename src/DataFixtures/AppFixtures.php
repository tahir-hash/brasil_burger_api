<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Gestionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $user = new Client();
        $user->setLogin('client@gmail.com');
        $user->setPrenom('Mbaye');
        $user->setNom('client');
        $user->setAdresse('Sicap');
        $user->setTelephone(771827286);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            'passer'
        );
        $user->setPassword($hashedPassword);
      //  $user->setRoles(['ROLE_CLIENT']);
      $user->setRoles(['ROLE_CLIENT']);
        $user1 = new Gestionnaire();
        $user1->setLogin('gestionnaire@gmail.com');
        $user1->setPrenom('Mbaye');
       $user1->setNom('gestionnaire');
       $user1->setRoles(['ROLE_GESTIONNAIRE']);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user1,
            'passer'
        );
        $user1->setPassword($hashedPassword);
        $manager->persist($user1);
        $manager->persist($user);
        $manager->flush();
    }
}
