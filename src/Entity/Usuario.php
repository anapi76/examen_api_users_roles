<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\Table(name: 'usuario')]
class Usuario
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idUser')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100)]
    private ?string $primerapellido = null;

    #[ORM\Column(length: 100,nullable: true)]
    private ?string $segundoapellido = null;

    #[ORM\Column(length: 50,unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private ?bool $sexo = null;

    #[ORM\Column(nullable: true)]
    private ?int $altura = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2, nullable: true)]
    private ?float $peso = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $alta = null;

    #[ORM\OneToMany(mappedBy: 'id_user', targetEntity: Conexiones::class)]
    private Collection $conexiones;

    #[ORM\ManyToOne(inversedBy: 'usuarios')]
    #[ORM\JoinColumn(nullable: false,name: 'idRol', referencedColumnName: 'idRol')]
    private ?Roles $rol = null;

    public function __construct()
    {

        $this->conexiones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrimerapellido(): ?string
    {
        return $this->primerapellido;
    }

    public function setPrimerapellido(string $primerapellido): static
    {
        $this->primerapellido = $primerapellido;

        return $this;
    }

    public function getSegundoapellido(): ?string
    {
        return $this->segundoapellido;
    }

    public function setSegundoapellido(string $segundoapellido): static
    {
        $this->segundoapellido = $segundoapellido;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function isSexo(): ?bool
    {
        return $this->sexo;
    }

    public function setSexo(bool $sexo): static
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getAltura(): ?int
    {
        return $this->altura;
    }

    public function setAltura(?int $altura): static
    {
        $this->altura = $altura;

        return $this;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(?float $peso): static
    {
        $this->peso = $peso;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fechaNacimiento): static
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    public function getAlta(): ?\DateTimeInterface
    {
        return $this->alta;
    }

    public function setAlta(\DateTimeInterface $alta): static
    {
        $this->alta = $alta;

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
            $conexion->setIdUser($this);
        }
        return $this;
    }

    public function removeConexion(Conexiones $conexion): static
    {
        if ($this->conexiones->removeElement($conexion)) {
            // set the owning side to null (unless already changed)
            if ($conexion->getIdUser() === $this) {
                $conexion->setIdUser(null);
            }
        }

        return $this;
    }

    public function getRol(): ?Roles
    {
        return $this->rol;
    }

    public function setRol(?Roles $rol): static
    {
        $this->rol = $rol;

        return $this;
    }
}
