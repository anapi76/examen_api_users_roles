<?php

namespace App\Entity;

use App\Repository\ConexionesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConexionesRepository::class)]
#[ORM\Table(name: 'conexiones')]
class Conexiones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idConexion')]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fin = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $status = false;

    #[ORM\ManyToOne(inversedBy: 'conexiones')]
    #[ORM\JoinColumn(nullable: false,name: 'idUser', referencedColumnName: 'idUser')]
    private ?usuario $id_user = null;

    #[ORM\ManyToOne(inversedBy: 'conexiones')]
    #[ORM\JoinColumn(nullable: false,name: 'idIp', referencedColumnName: 'id')]
    private ?Ips $id_ip = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInicio(): ?\DateTimeInterface
    {
        return $this->inicio;
    }

    public function setInicio(\DateTimeInterface $inicio): static
    {
        $this->inicio = $inicio;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin): static
    {
        $this->fin = $fin;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getIdUser(): ?usuario
    {
        return $this->id_user;
    }

    public function setIdUser(?usuario $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdIp(): ?Ips
    {
        return $this->id_ip;
    }

    public function setIdIp(?Ips $id_ip): static
    {
        $this->id_ip = $id_ip;

        return $this;
    }
}
