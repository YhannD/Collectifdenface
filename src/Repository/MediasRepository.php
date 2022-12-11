<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Medias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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


    public function getPaginatedMedias($page, $limit, $filters = null, $section = null, $mots = null)
    {
        $query = $this->createQueryBuilder('m')
            ->select( 'm')
            ->addSelect('c')
            ->innerJoin('m.categories', 'c')
            ->orderBy('m.created_at', 'DESC');

        if ($mots != null) {
            $query
                ->andWhere('MATCH_AGAINST(m.name, m.description) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }

        // On filtre les données
        if ($filters != null) {
            $query
                ->andWhere('c.id IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

        // On filtre les sections
        if ($section != null) {
            $query
                ->leftJoin('m.mediasSections', 'ms')
                ->andWhere('ms.id = :section')
                ->setParameter(':section', $section);
        }

        $query
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }


    public function getTotalMedias($mots = null, $filters = null, $section = null, )
    {
        $query = $this->createQueryBuilder('m')
            ->select('COUNT(m)')
            ->leftJoin('m.categories', 'c')
            ->orderBy('m.created_at', 'DESC');

        if ($mots != null) {
            $query->andWhere('MATCH_AGAINST(m.name, m.description) AGAINST (:mots boolean)>0')
                ->setParameter('mots', $mots);
        }

        // On filtre les données
        if ($filters != null) {
            $query->andWhere('c.id IN(:cats)')
                ->setParameter(':cats', array_values($filters));
        }

//         On filtre les sections
        if ($section != null) {
            $query
                ->leftJoin('m.mediasSections', 'ms')
                ->andWhere('ms.id = :section')
                ->setParameter(':section', $section);
        }
dump($query->getQuery());
        return $query->getQuery()->getSingleScalarResult();
    }

    public function findMediasPaginated(int $page, $filters = null, int $limit = 6): array
    {
        $limit = abs($limit);

        $result = [];

        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('m','c' )
            ->from('App\Entity\Medias', 'm')
            ->leftjoin('m.categories', 'c');

            if ($filters != null) {
                $query
                    ->andWhere('c.id IN(:cats)')
                    ->setParameter(':cats', array_values($filters));
            }
          $query
            ->setMaxResults($limit)
            ->setFirstResult(($page * $limit) - $limit);

        $paginator = new Paginator($query);
        $data = $paginator->getQuery()->getResult();

        //On vérifie qu'on a des données
        if(empty($data)){
            return $result;
        }

        //On calcule le nombre de pages
        $pages = ceil($paginator->count() / $limit);

        // On remplit le tableau
        $result['data'] = $data;
        $result['pages'] = $pages;
        $result['page'] = $page;
        $result['limit'] = $limit;
dump($data, $limit, $filters);
        return $result;
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
