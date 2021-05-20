<?php


namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findAll()
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }
    
    public function findByCategory($value)
    {
        return $this->createQueryBuilder('producto')
            ->leftJoin('producto.categorias', 'prod_cat')
            ->leftJoin('prod_cat.categoria', 'cat')
            ->where('cat.nombre = :value')
            ->setParameter('value', $value)
            ->getQuery()->execute();
    }
}