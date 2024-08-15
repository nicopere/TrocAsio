<?php

namespace App\Repository;

use App\Entity\MaintenanceOperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MaintenanceOperation>
 */
class MaintenanceOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaintenanceOperation::class);
    }

    public function findByDate(array $dates = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('m');

        if (\array_key_exists('start', $dates)) {
            $qb->andWhere('m.date >= :start')
               ->setParameter('start', new \DateTimeImmutable($dates['start']));
        }

        if (\array_key_exists('end', $dates)) {
            $qb->andWhere('m.date <= :end')
               ->setParameter('end', new \DateTimeImmutable($dates['end']));
        }

        $qb->orderBy('m.date', 'DESC');

        return $qb;
    }

    //    /**
    //     * @return MaintenanceOperation[] Returns an array of MaintenanceOperation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MaintenanceOperation
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
