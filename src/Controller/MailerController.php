<?php

namespace App\Controller;

use App\Entity\Client;
use App\Service\ServiceMailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MailerController extends AbstractController
{
    #[Route("/confirmer-mon-compte/{token}", name : "confirm_account")]
    public function __invoke(
        string $token,
        ClientRepository $repo,
        EntityManagerInterface $entityManager
    ) {        
        $client = $repo->findOneBy(["token" => $token]);
        if ($client && $client->getExpireAt() > new \DateTime()) {
            $client->setToken(null);
            $client->setIsEnabled(true);
            $client->setExpireAt(null);
            $entityManager->persist($client);
            $entityManager->flush();
            return $this->render('mailer/succes.html.twig');
        } else {
            $obj=["status" => 400,"message" => "erreur"];
            return $this->json(json_encode($obj),400);
        }
    }
    

    
}
