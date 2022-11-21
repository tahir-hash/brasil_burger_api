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
    public function __invoke(Request $request, ClientRepository $repo, EntityManagerInterface $entityManager)
   {
        $token= $request->get('token');
        $user = $repo->findOneBy(["token" => $token]);
        if ($user && $user->getExpireAt() > new \DateTime() && $user->isIsEnabled()==false) {
            $user->setToken(null);
            $user->setIsEnabled(true);
           // $entityManager->persist($user);
            $entityManager->flush();
            //return $this->render('mailer/succes.html.twig');
            return $this->json(["succes"=>"diadieuf","status"=>200],200);
        }
        return $this->json(["error"=>"dialoul","status"=>400],Response::HTTP_BAD_REQUEST);

   }
}
