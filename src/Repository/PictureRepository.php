<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Picture>
 *
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    public function findVisibleFromId(string $id): array
    {
        if ($id === "0") {
            return $this->createQueryBuilder('p')
                ->andWhere('p.visibility = :visibility')
                ->setParameter('visibility', "1")
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(5)
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('p')
                ->andWhere('p.visibility = :visibility AND p.id < :id')
                ->setParameter('visibility', "1")
                ->setParameter('id', $id)
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(5)
                ->getQuery()
                ->getResult();
        }
    }

    public function findFromId(string $id): array
    {
        if ($id === "0") {
            return $this->createQueryBuilder('p')
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(5)
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('p')
                ->andWhere('p.id < :id')
                ->setParameter('id', $id)
                ->orderBy('p.id', 'DESC')
                ->setMaxResults(5)
                ->getQuery()
                ->getResult();
        }
    }

    public function findById(int $id){
        return $this->createQueryBuilder('p')
                ->andWhere('p.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getOneOrNullResult();
    }
}
