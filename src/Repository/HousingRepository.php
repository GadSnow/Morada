<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Housing;
use App\Entity\HousingSearch;
use App\Entity\Quarter;
use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->findVisibleQuery()
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findAllVisibleItemsQuery()
    {
        return $this->findVisibleQuery()
            ->getQuery();
    }

    public function findBySearchQuery(Request $request = null)
    {
        $query = $this->findVisibleQuery()
            ->leftJoin('App\Entity\Quarter', 'q', Join::WITH, "q.id = h.quarter")
            ->leftJoin('App\Entity\City', 'c', Join::WITH, "c.id = q.city")
            ->leftJoin('App\Entity\Region', 'r', Join::WITH, "r.id = c.region");
        if ($request != null && !$request->query->has('biens')) {
            $query = $query->setMaxResults(3);
        }
        if ($request->query->get('maxPrice') != "") {
            $query = $query
                ->andWhere('h.price <= :price')
                ->setParameter(':price', $request->query->getInt('maxPrice'));
        }

        if ($request->query->get('city') != "") {
            $query = $query
                ->andWhere("q.quarterName = :place OR r.regionName = :place OR c.cityName = :place")
                ->setParameter(':place', $request->query->get('city'));
        }

        if ($request->query->get('rooms') != "") {
            $query = $query
                ->andWhere('h.numberOfRooms = :rooms')
                ->setParameter(':rooms', $request->query->get('rooms'));
        }

        return $query->getQuery();
    }

    public function findHousingByQuarter($quarter_name)
    {
        return $this->findVisibleQuery()
            ->leftJoin('App\Entity\Quarter', 'q', Join::WITH, "q.id = h.quarter")
            ->andWhere(('q.quarterName = :quarter_name'))
            ->setParameters(['quarter_name' => $quarter_name])
            ->getQuery();
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
