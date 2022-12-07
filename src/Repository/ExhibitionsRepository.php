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

    /**
     * Returns all Annonces per page
     * @return void
     */
    public function getPaginatedExhibitions($page, $limit, $filters = null,)
    {
        $query = $this->createQueryBuilder('m')
            ->select('c', 'm')
            ->leftJoin('m.categories', 'c')
            ->orderBy('m.created_at', 'DESC');

        // On filtre les données
        if($filters != null){
            $query->andWhere('c.id IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        $query->orderBy('m.created_at')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * Returns number of Annonces
     * @return void
     */
    public function getTotalExhibitions($filters = null, $section = null, $mots = null){
        $query = $this->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->leftJoin('m.categories', 'c')
            ->orderBy('m.created_at', 'DESC');

//        if($mots != null){
//            $query->andWhere('MATCH_AGAINST(m.name, m.description) AGAINST (:mots boolean)>0')
//                ->setParameter('mots', $mots);
//        }

        // On filtre les données
        if($filters != null){
            $query->andWhere('c.id IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        // On filtre les sections
        if ($section != null) {
            $query
                ->leftJoin('m.mediasSections', 'ms')
                ->andWhere('ms.id = :section')
                ->setParameter(':section', $section);
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
