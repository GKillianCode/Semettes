<?php

namespace App\Repository;

use App\Entity\ExceptionalClosedSlot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExceptionalClosedSlot>
 *
 * @method ExceptionalClosedSlot|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExceptionalClosedSlot|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExceptionalClosedSlot[]    findAll()
 * @method ExceptionalClosedSlot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExceptionalClosedSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExceptionalClosedSlot::class);
    }

    public function add(ExceptionalClosedSlot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ExceptionalClosedSlot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ExceptionalClosedSlot[] Returns an array of ExceptionalClosedSlot objects
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

//    public function findOneBySomeField($value): ?ExceptionalClosedSlot
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
