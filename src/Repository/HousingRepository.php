<?php

namespace App\Repository;

use App\Entity\Housing;
use App\Entity\HousingSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Housing>
 *
 * @method Housing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Housing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Housing[]    findAll()
 * @method Housing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HousingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Housing::class);
    }

    public function save(Housing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Housing $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findVisibleQuery()
    {
        return $this->createQueryBuilder('h')
            ->where('h.sold = false');
    }

    public function findLatest()
    {
        return $this->createQueryBuilder('h')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    public function findAllVisibleItems()
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    public function findBySearch(HousingSearch $search)
    {
        $query = $this->findVisibleQuery();

        if ($search->getMaxPrice()) {
            $query = $query
                ->andWhere('h.price = :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }

        dd($query->getQuery());

        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Housing[] Returns an array of Housing objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Housing
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
