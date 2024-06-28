<?php

namespace App\Repository;

use App\Entity\Present;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Present>
 *
 * @method Present|null find($id, $lockMode = null, $lockVersion = null)
 * @method Present|null findOneBy(array $criteria, array $orderBy = null)
 * @method Present[]    findAll()
 * @method Present[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Present::class);
    }
    
    
    public function findById($value): ?Present
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

//    /**
//     * @return Present[] Returns an array of Present objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


}
