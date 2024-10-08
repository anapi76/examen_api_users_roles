<?php

namespace App\Repository;

use App\Entity\Conexiones;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conexiones>
 *
 * @method Conexiones|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conexiones|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conexiones[]    findAll()
 * @method Conexiones[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConexionesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conexiones::class);
    }

    public function persist(Conexiones $conexion):void
    {
        try {
            $this->getEntityManager()->persist($conexion);
        } catch (\Exception $e) {
            throw $e;
        }
    } 

//    /**
//     * @return Conexiones[] Returns an array of Conexiones objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Conexiones
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
