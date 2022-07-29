<?php

namespace App\Repository;

use App\Entity\DetailsProduits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailsProduits>
 *
 * @method DetailsProduits|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailsProduits|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailsProduits[]    findAll()
 * @method DetailsProduits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailsProduits::class);
    }

    public function add(DetailsProduits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DetailsProduits $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return DetailsProduits[] Returns an array of DetailsProduits objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetailsProduits
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
