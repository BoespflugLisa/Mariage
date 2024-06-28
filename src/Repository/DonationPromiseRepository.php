<?php

namespace App\Repository;

use App\Entity\DonationPromise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DonationPromise>
 *
 * @method DonationPromise|null find($id, $lockMode = null, $lockVersion = null)
 * @method DonationPromise|null findOneBy(array $criteria, array $orderBy = null)
 * @method DonationPromise[]    findAll()
 * @method DonationPromise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonationPromiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DonationPromise::class);
    }

//    /**
//     * @return DonationPromise[] Returns an array of DonationPromise objects
//     */
    public function findByView($value): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.view = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?DonationPromise
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
