<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"=>[
            'normalization_context' => ['groups'=>['quartier:read']],
        ],
        "post"=>[
            'denormalization_context' => ['groups' => ['quartier:write']],
            'normalization_context' => ['groups' => ['quartier:read']],
        ]
        ], itemOperations:[
            "put"=>[
                'denormalization_context' => ['groups' => ['quartier:write']],
            'normalization_context' => ['groups' => ['quartier:read']],
            ],
            "get" => [
            "security" => "is_granted('Zone_read', object)",
            ]
        ]
)]
#[UniqueEntity(fields:'libelle',message: 'le libelle du quartier doit etre unique!')]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["zone:read"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["zone:read","zone:write"])]
    #[Assert\NotBlank(message: 'le libelle ne doit pas etre vide')]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["quartier:write"])]
    #[Assert\NotBlank(message: 'Le zone ne doit pas etre vide')]
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
