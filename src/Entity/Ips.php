<?php

namespace App\Entity;

use App\Repository\IpsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IpsRepository::class)]
#[ORM\Table(name: 'ips')]
class Ips
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id')]
    private ?int $id = null;

    #[ORM\Column(length: 15, unique: true)]
    private ?string $direccion = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $status = false;

    #[ORM\OneToMany(mappedBy: 'id_ip', targetEntity: Conexiones::class)]
    private Collection $conexiones;

    public function __construct()
    {
        $this->conexiones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

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

    /**
     * @return Collection<int, Conexiones>
     */
    public function getConexiones(): Collection
    {
        return $this->conexiones;
    }

    public function addConexion(Conexiones $conexion): static
    {
        if (!$this->conexiones->contains($conexion)) {
            $this->conexiones->add($conexion);
            $conexion->setIdIp($this);
        }

        return $this;
    }

    public function removeConexion(Conexiones $conexion): static
    {
        if ($this->conexiones->removeElement($conexion)) {
            // set the owning side to null (unless already changed)
            if ($conexion->getIdIp() === $this) {
                $conexion->setIdIp(null);
            }
        }

        return $this;
    }
}
