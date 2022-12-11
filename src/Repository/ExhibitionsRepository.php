<?php

namespace App\Repository;

use App\Entity\Exhibitions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exhibitions>
 *
 * @method Exhibitions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exhibitions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exhibitions[]    findAll()
 * @method Exhibitions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExhibitionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exhibitions::class);
    }

    public function add(Exhibitions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Exhibitions $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getPaginatedExhibitions($page, $limit, $filters = null,)
    {
        $query = $this->createQueryBuilder('e')
            ->select( 'y', 'e')
            ->leftJoin('e.exhibitionsYears', 'y')
            ->orderBy('e.created_at', 'DESC');

        // On filtre les données
        if($filters != null){
            $query->andWhere('y.id IN(:year)')
                ->setParameter(':year', array_values($filters));
        }

        $query->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }

    public function getTotalExhibitions($filters = null){
        $query = $this->createQueryBuilder('e')
            ->select('COUNT(e)')
            ->leftJoin('e.exhibitionsYears', 'y')
            ->orderBy('e.created_at', 'DESC');

        // On filtre les données
        if($filters != null){
            $query->andWhere('y.id IN(:year)')
                ->setParameter(':year', array_values($filters));
        }

        return $query->getQuery()->getSingleScalarResult();
    }

//    /**
//     * @return Exhibitions[] Returns an array of Exhibitions objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Exhibitions
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
