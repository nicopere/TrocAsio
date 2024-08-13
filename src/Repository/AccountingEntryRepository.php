<?php

namespace App\Repository;

use App\Entity\AccountingEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountingEntry>
 */
class AccountingEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountingEntry::class);
    }

    public function findByDate(array $dates = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');

        if (\array_key_exists('start', $dates)) {
            $qb->andWhere('a.date >= :start')
               ->setParameter('start', new \DateTimeImmutable($dates['start']));
        }

        if (\array_key_exists('end', $dates)) {
            $qb->andWhere('a.date <= :end')
               ->setParameter('end', new \DateTimeImmutable($dates['end']));
        }

        return $qb;
    }

    public function balance(): ?float {
        return $this->createQueryBuilder('e')
                    ->select('sum(e.amount)')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    //    /**
    //     * @return AccountingEntry[] Returns an array of AccountingEntry objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AccountingEntry
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
