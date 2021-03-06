<?php


namespace App\Repository;

use App\Entity\Pedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pedido|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pedido|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pedido[]    findAll()
 * @method Pedido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pedido::class);
    }

    /**
     * @param $getId
     * @return int|mixed[]|string
     * Averiguamos si un producto tiene talla.
     */
    public function conTalla($getId)
    {
        $query = $this->createQueryBuilder('pedido')
            ->select('cat.con_talla')
            ->leftJoin('producto.categorias', 'prod_cat')
            ->leftJoin('prod_cat.categoria', 'cat')
            ->where('producto.id = :id')
            ->setParameter('id', $getId)
            ->getQuery()->getArrayResult();

        return $query;
    }
}