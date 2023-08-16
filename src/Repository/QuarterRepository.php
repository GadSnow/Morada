<?php

namespace App\Repository;

use App\Entity\Quarter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quarter>
 *
 * @method Quarter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quarter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quarter[]    findAll()
 * @method Quarter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuarterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quarter::class);
    }

    public function save(Quarter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Quarter $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFirsts()
    {
        return $this->createQueryBuilder('q')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Quarter[] Returns an array of Quarter objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('q.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Quarter
    //    {
    //        return $this->createQueryBuilder('q')
    //            ->andWhere('q.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
