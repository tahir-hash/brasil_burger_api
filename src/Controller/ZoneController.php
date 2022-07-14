<?php

namespace App\Controller;

use App\Entity\Zone;
use App\Entity\Quartier;
use App\Repository\QuartierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ZoneController extends AbstractController
{
    #[Route("api/zones", name: "add_zone")]
    public function __invoke(Request $request, EntityManagerInterface $entityManager)
    {
        $zone = new Zone();
        $content = $request->getContent();
        $content = json_decode($content, true);
        $libelle = $content['libelle'];
        $prix = $content['prix'];
        $quartiers = $content['quartiers'];
        $zone->setLibelle($libelle);
        $zone->setPrix($prix);
        $entityManager->persist($zone);
        foreach ($quartiers as $value) {
            $quartier = new Quartier();
            $quartier->setLibelle($value);
            $quartier->setZone($zone);
            $entityManager->persist($quartier);
        }
        $entityManager->flush();
        return $this->json($zone,201, [],['groups'=>'zone:read']);
    }
}
