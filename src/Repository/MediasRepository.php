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
     * Returns all Annonces per page
     * @return void
     */
    public function getPaginatedMedias($page, $limit, $filters = null, $section = null)
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

        // On filtre les sections
        if ($section != null) {
            $query
                ->leftJoin('m.mediasSections', 'ms')
                ->andWhere('ms.id = :section')
                ->setParameter(':section', $section);
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
    public function getTotalMedias($filters = null, $section = null){
        $query = $this->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->leftJoin('m.categories', 'c')
            ->orderBy('m.created_at', 'DESC');

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

    public function search($mots = null){
        $query = $this->createQueryBuilder('m');
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(m.name, m.description) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }

        return $query->getQuery()->getResult();
    }
//    /**
//     * Récupère tous les medias en lien avec une recherche
//     * @param SearchData $search
//     * @return PaginationInterface
//     */
//    public function findImagesType(SearchData $search): PaginationInterface
//    {
//        $query = $this
//            ->createQueryBuilder('m')
//            ->select('c', 'm')
//            ->andWhere('m.mediasSections = 1')
//            ->join('m.categories', 'c');
//
//        if (!empty($search->categories)) {
//            $query = $query
//                ->andWhere('c.id IN (:categories)')
//                ->setParameter('categories', $search->categories);
//        }
//
//        $query = $query->getQuery();
//        return $this->paginator->paginate(
//            $query,
//            $search->page,
//            6
//        );
//    }

    public function selectByCategoryAndSection(SearchData $search, $section = null): PaginationInterface
    {

        $query = $this->createQueryBuilder('m')
            ->select('c', 'm')
            ->leftJoin('m.categories', 'c')
            ->orderBy('m.created_at', 'DESC');

        if ($section != null) {
            $query
                ->leftJoin('m.mediasSections', 'ms')
                ->andWhere('ms.id = :section')
                ->setParameter(':section', $section);
        }
        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $search->categories);

        }
            $query = $query->getQuery();
            return $this->paginator->paginate(
                $query,
                $search->page,
                8
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
