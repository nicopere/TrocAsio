<?php

namespace App\Repository;

use App\Entity\Calculator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Calculator>
 */
class CalculatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calculator::class);
    }

    public function findByStatus(string $status = ''): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c');

        if (strlen($status) > 0) {
            $qb->andWhere('c.status = :status')
               ->setParameter('status', $status);
        }

        return $qb;
    }

    public function nextId(): int {
        $lastCalculator = $this->createQueryBuilder('c')
                               ->orderBy('c.id', 'DESC')
                               ->SetMaxResults(1)
                               ->getQuery()
                               ->getOneOrNullResult();
        $currentId = $lastCalculator ? $lastCalculator->getId() : 0;
        return $currentId + 1;
    }

    //    /**
    //     * @return Calculator[] Returns an array of Calculator objects
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

    //    public function findOneBySomeField($value): ?Calculator
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
