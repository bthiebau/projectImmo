<?php

namespace App\Repository;

use App\Entity\BienImmo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BienImmo>
 */
class BienImmoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BienImmo::class);
    }

    //    /**
    //     * @return BienImmo[] Returns an array of BienImmo objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BienImmo
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function searchProperties(array $criteria, $sortField, $sortOrder)
    {
        $qb = $this->createQueryBuilder('b');

        // Les critères
        if (!empty($criteria['propertyType'])) {
            $qb->andWhere('b.propertyType = :propertyType')
               ->setParameter('propertyType', $criteria['propertyType']);
        }

        if (!empty($criteria['city'])) {
            $qb->andWhere('b.city = :city')
               ->setParameter('city', $criteria['city']);
        }

        if (!empty($criteria['nbRooms'])) {
            $qb->andWhere('b.nbRooms = :nbRooms')
               ->setParameter('nbRooms', $criteria['nbRooms']);
        }

        $qb->orderBy('b.' . $sortField, $sortOrder);

        return $qb->getQuery()->getResult();
    }
}
