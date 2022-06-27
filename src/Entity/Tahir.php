<?php

namespace App\Entity;

use Collator;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TahirRepository;
use App\Controller\TestMailController;
use PhpParser\ErrorHandler\Collecting;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: TahirRepository::class)]
#[ApiResource(collectionOperations:["get","post"=>[
    'denormalization_context' => ['groups' => ['post:tahir']],
],"mailActived"=>[
    "method"=>"PATCH",
    "path"=>"tahirs/{token}/activate",
    "controller"=> TestMailController::class,
    "deserialize"=>false
]])]
class Tahir implements  PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["post:tahir"])]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["post:tahir"])]
    private $nomComplet;

    #[ORM\Column(type: 'boolean')]
    private $isActived;

    #[ORM\Column(type: 'datetime')]
    private $expireAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[Groups(["post:tahir"])]
    #[SerializedName('password')]
    private $plainPassword;

    public function __construct()
    {
        $this->isActived= false;
        $this->generateToken();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNomComplet(): ?string
    {
        return $this->nomComplet;
    }

    public function setNomComplet(string $nomComplet): self
    {
        $this->nomComplet = $nomComplet;

        return $this;
    }

    public function isIsActived(): ?bool
    {
        return $this->isActived;
    }

    public function setIsActived(bool $isActived): self
    {
        $this->isActived = $isActived;

        return $this;
    }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    private function generateToken()
    {
        $this->token= rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
        $this->expireAt= new \DateTime('+1 days');
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
