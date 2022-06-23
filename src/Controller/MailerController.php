<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    #[Route('/email')]
    public function __invoke(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('mbayepro6@gmail.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Creation de compte')
            ->text('Activer votre compte')
            ->html('<a>Activer votre compte en cliquant sur ce lien!</a>');

        $mailer->send($email);

        // ...
        return $this->render('mailer/index.html.twig');
    }
}