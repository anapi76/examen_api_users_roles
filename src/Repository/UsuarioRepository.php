<?php

namespace App\Repository;

use App\Entity\Usuario;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Usuario>
 *
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function save(Usuario $usuario, bool $flush = false): void
    {
        try {
            $this->getEntityManager()->persist($usuario);
            if ($flush) {
                $this->getEntityManager()->flush();
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function usuarioJSON(Usuario $usuario): mixed
    {
        $json = array();
        $json = array(
            'NOMBRE' => $usuario->getNombre(),
            'PRIMER APELLIDO' => $usuario->getPrimerapellido(),
            'SEGUNDO APELLIDO' => $usuario->getSegundoapellido(),
            'USERNAME' => $usuario->getUsername(),
            'SEXO' => $usuario->isSexo(),
            'ALTURA' => $usuario->getAltura(),
            'PESO' => $usuario->getPeso(),
            'FECHA DE NACIMIENTO' => $usuario->getFechaNacimiento(),
            'ALTA' => $usuario->getAlta(),
            'ROL' => $usuario->getRol()->getNombre(),
            'CONEXIONES' => $this->conexionJSON($usuario->getConexiones()),
            'DIRECCIONES IPS' => $this->ipJSON($usuario->getConexiones())
        );
        return $json;
    }

    public function conexionJSON(Collection $conexiones): mixed
    {
        $json = array();
        foreach ($conexiones as $conexion) {
            $json []= array(
                'FECHA INICIO' => $conexion->getInicio(),
                'FECHA FIN' => $conexion->getFin(),
                'ESTADO' => $conexion->isStatus() ? 'ACTIVO' : 'INACTIVO'
            );
        }
        return $json;
    }

    public function ipJSON(Collection $conexiones): mixed
    {
        $json = array();
        foreach ($conexiones as $conexion) {
            $json[] = array(
                'IP' => $conexion->getIdIp()->getDireccion()
            );
        }
        return $json;
    }

    public function testInsert(string $nombre): bool
    {
        if (empty($nombre) || is_null($nombre)) {
            return false;
        } else {
            $entidad = $this->findOneBy(['username' => $nombre]);
            if (empty($entidad))
                return false;
            else {
                return true;
            }
        }
    }

    public function testUpdate(Usuario $usuario): bool
    {
        if (is_null($usuario)) {
            return false;
        } else {
            $entidad = $this->find($usuario);
            if (empty($entidad))
                return false;
            else {
                return true;
            }
        }
    }

    public function testDelete(Usuario $usuario): bool
    {
        if (is_null($usuario)) {
            return false;
        } else {
            $entidad = $this->find($usuario);
            if ($entidad->getRol()->getNombre()==='bloqueado'){
                return true;
            }
                
            else {
                return false;
            }
        }
    }

    //    /**
    //     * @return Usuario[] Returns an array of Usuario objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Usuario
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
