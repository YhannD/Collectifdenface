<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Medias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Medias>
 *
 * @method Medias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medias[]    findAll()
 * @method Medias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MediasRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Medias::class);
        $this->paginator = $paginator;
    }

    public function add(Medias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Medias $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère tous les medias en lien avec une recherche
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('m')
            ->select('c', 'm')
            ->join('m.categories', 'c');

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );
    }

    /**
     * Récupère tous les medias en lien avec une recherche
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findImagesType(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('m')
            ->select('c', 'm')
            ->andWhere('m.mediasSections = 1')
            ->join('m.categories', 'c');

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );
    }

    /**
     * Récupère tous les medias en lien avec une recherche
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findMusicsType(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('m')
            ->select('c', 'm')
            ->andWhere('m.mediasSections = 2')
            ->join('m.categories', 'c');

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );
    }

    /**
     * Récupère tous les medias en lien avec une recherche
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findVideosType(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('m')
            ->select('c', 'm')
            ->andWhere('m.mediasSections = 3')
            ->join('m.categories', 'c');

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );
    }
    /**
     * Récupère tous les medias en lien avec une recherche
     * @param SearchData $search
     * @return PaginationInterface
     */
    public function findEditionType(SearchData $search): PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('m')
            ->select('c', 'm')
            ->andWhere('m.mediasSections = 4')
            ->join('m.categories', 'c');

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            6
        );
    }

//    /**
//     * @return Medias[] Returns an array of Medias objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Medias
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
