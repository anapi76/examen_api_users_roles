<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
#[ORM\Table(name: 'roles')]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idRol')]
    private ?int $id = null;

    #[ORM\Column(length: 50,unique: true)]
    private ?string $nombre = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $status = false;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $admin = false;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $usuario = false;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $invitado = true;

    #[ORM\OneToMany(mappedBy: 'rol', targetEntity: Usuario::class)]
    private Collection $usuarios;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
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

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): static
    {
        $this->admin = $admin;

        return $this;
    }

    public function isUsuario(): ?bool
    {
        return $this->usuario;
    }

    public function setUsuario(bool $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function isInvitado(): ?bool
    {
        return $this->invitado;
    }

    public function setInvitado(bool $invitado): static
    {
        $this->invitado = $invitado;

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): static
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
            $usuario->setRol($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): static
    {
        if ($this->usuarios->removeElement($usuario)) {
            // set the owning side to null (unless already changed)
            if ($usuario->getRol() === $this) {
                $usuario->setRol(null);
            }
        }

        return $this;
    }

}
