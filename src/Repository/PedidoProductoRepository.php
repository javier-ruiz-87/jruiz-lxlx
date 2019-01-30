<?php

namespace App\Repository;

use App\Entity\PedidoProducto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PedidoProducto|null find($id, $lockMode = null, $lockVersion = null)
 * @method PedidoProducto|null findOneBy(array $criteria, array $orderBy = null)
 * @method PedidoProducto[]    findAll()
 * @method PedidoProducto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoProductoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PedidoProducto::class);
    }

    public function save($pedidoProducto)
    {
        $em = $this->getEntityManager();
        $em->persist($pedidoProducto);
        $em->flush();

        return;
    }

    // /**
    //  * @return PedidoProducto[] Returns an array of PedidoProducto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PedidoProducto
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
