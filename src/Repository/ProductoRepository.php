<?php


namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 4;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    /**
     * @param int $offset
     * @param string $tipo
     * @param string $search
     * @return Paginator
     * Obtenemos todos los productos paginados, podemos recibir el tipo de producto y una búsqueda para poder filtrar.
     */
    public function getAll(int $offset, string $tipo, string $search): Paginator
    {
        $query = $this->createQueryBuilder('producto')
            ->orderBy('producto.actualizado', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset);

        if ($tipo !== 'todos') {
            $query = $query
                ->leftJoin('producto.categorias', 'prod_cat')
                ->leftJoin('prod_cat.categoria', 'cat')
                ->where('cat.nombre = :tipo')
                ->setParameter('tipo', $tipo);
        }

        if ($search !== '') {
            $searchArr = explode(' ', $search);
            $consulta = '';

            foreach ($searchArr as $key => $busqueda) {
                $param = 'busqueda' . $key;
                $query = $query->setParameter($param, '%' . $busqueda . '%');
                $consulta .= $key === 0 ? ' producto.nombre LIKE :' . $param : ' OR producto.nombre LIKE :' . $param;
            }

            $query = $query->andWhere($consulta);
        }

        return new Paginator($query->getQuery());
    }

    /**
     * @param $getId
     * @return int|mixed[]|string
     * Obtenemos si un producto tiene talla o no.
     */
    public function conTalla($getId)
    {
        $query = $this->createQueryBuilder('producto')
            ->select('cat.con_talla')
            ->leftJoin('producto.categorias', 'prod_cat')
            ->leftJoin('prod_cat.categoria', 'cat')
            ->where('producto.id = :id')
            ->setParameter('id', $getId)
            ->getQuery()->getArrayResult();
        
        return $query;
    }
}