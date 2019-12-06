<?php

namespace App\Repository;

use App\Entity\Exposition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Exposition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exposition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exposition[]    findAll()
 * @method Exposition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpositionRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exposition::class);
    }

    public function findBeforeToday()
    {
        $date = date('Y-m-d H:i:s');
        $query =  $this->createQueryBuilder('exposition')
            ->where('exposition.date < :val')
            ->setParameter('val', $date)
            ->orderBy('exposition.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
        return $query;
    }

    public function findAfterToday()
    {
        $date = date('Y-m-d H:i:s');
        $query =  $this->createQueryBuilder('exposition')
            ->where('exposition.date >=  :val')
            ->setParameter('val', $date)
            ->orderBy('exposition.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
        return $query;
    }

    /*
    public function findOneBySomeField($value): ?Exposition
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
