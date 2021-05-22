<?php


namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findAll()
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 4;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    public function findAllAndPaginate($offset): Paginator
    {
        $query = $this->createQueryBuilder('producto')
            ->orderBy('producto.actualizado', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }
    
    public function findByCategory($value, $offset): Paginator
    {
        $query = $this->createQueryBuilder('producto')
            ->leftJoin('producto.categorias', 'prod_cat')
            ->leftJoin('prod_cat.categoria', 'cat')
            ->where('cat.nombre = :value')
            ->setParameter('value', $value)
            ->orderBy('producto.actualizado', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();
        
        return new Paginator($query);
    }

    public function findByCategoryPaginator(Producto $producto, int $offset): Paginator
    {
        $query = $this->createQueryBuilder('producto')
            ->andWhere('p.conference = :conference')
            ->setParameter('conference', $producto)
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery()
        ;

        return new Paginator($query);
    }
}