<?php

namespace App\Repository;

use App\Entity\ImagenesProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImagenesProducto|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagenesProducto|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagenesProducto[]    findAll()
 * @method ImagenesProducto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagenesProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagenesProducto::class);
    }

    // /**
    //  * @return ImagenesProducto[] Returns an array of ImagenesProducto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImagenesProducto
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
