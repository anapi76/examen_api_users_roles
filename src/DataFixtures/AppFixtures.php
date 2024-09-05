<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use App\Entity\Usuario;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $registrado=new Roles();
        $registrado->setNombre('registrado');
        $registrado->setStatus(true);
        $registrado->setAdmin(false);
        $registrado->setUsuario(true);
        $registrado->setInvitado(true);
        $manager->persist($registrado);

        $bloqueado=new Roles();
        $bloqueado->setNombre('bloqueado');
        $bloqueado->setStatus(false);
        $bloqueado->setAdmin(false);
        $bloqueado->setUsuario(false);
        $bloqueado->setInvitado(false);
        $manager->persist($bloqueado);

        $usuario=new Usuario();
        $usuario->setNombre('Pedro');
        $usuario->setPrimerapellido('Martínez');
        $usuario->setSegundoApellido('Martínez');
        $usuario->setUsername('Goku');
        $usuario->setSexo(true);
        $usuario->setAltura(175);
        $usuario->setPeso(80.00);
        $usuario->setFechaNacimiento(new DateTime('17-04-2000'));
        $usuario->setAlta(new DateTime('17-01-2024'));
        $usuario->setRol($registrado);
        $manager->persist($usuario);

        $manager->flush();
    }
}
