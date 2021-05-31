<?php

namespace App\Repository;

use App\Entity\TallasProductos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TallasProductos|null find($id, $lockMode = null, $lockVersion = null)
 * @method TallasProductos|null findOneBy(array $criteria, array $orderBy = null)
 * @method TallasProductos[]    findAll()
 * @method TallasProductos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TallasProductosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TallasProductos::class);
    }

    // /**
    //  * @return TallasProductos[] Returns an array of TallasProductos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TallasProductos
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
