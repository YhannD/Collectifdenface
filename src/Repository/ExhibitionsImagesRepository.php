<?php

namespace App\Repository;

use App\Entity\ExhibitionsImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExhibitionsImages>
 *
 * @method ExhibitionsImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExhibitionsImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExhibitionsImages[]    findAll()
 * @method ExhibitionsImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExhibitionsImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExhibitionsImages::class);
    }

    public function add(ExhibitionsImages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExhibitionsImages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExhibitionsImages[] Returns an array of ExhibitionsImages objects
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

//    public function findOneBySomeField($value): ?ExhibitionsImages
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
