<?php

namespace App\Repository;

use App\Entity\Booking;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use function PHPSTORM_META\type;

/**
 * @extends ServiceEntityRepository<Booking>
 *
 * @method Booking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Booking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Booking[]    findAll()
 * @method Booking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function add(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Booking $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findFromTodayOnward(): array
    {
        $now = date('Y-m-d H:i:s');
        return $this->createQueryBuilder('b')
            ->andWhere('b.start_time >= :time')
            ->setParameter('time', $now)
            //->orderBy('b.id', 'ASC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findFromdXtoDy(\DateTime $start, \DateTime $end): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = '
            SELECT b.meeting_room_id FROM booking b
            INNER JOIN meeting_room m ON b.meeting_room_id = m.id
            WHERE 
            (CAST(b.start_time as datetime) = CAST(:start as datetime) AND CAST(b.end_time as datetime) = CAST(:end as datetime))
            OR 
            (CAST(b.end_time as datetime) > CAST(:start as date) AND CAST(b.end_time as datetime) < CAST(:end as date))
            OR 
            (CAST(b.start_time as datetime) > CAST(:start as date)
            AND CAST(b.start_time as datetime) < CAST(:end as date))
            ';
            
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(
            [
                'start' => $start->format('Y-m-d H:i:s'),
                'end' => $end->format('Y-m-d H:i:s')
            ]
        );

        // returns an array of arrays (i.e. a raw data set)
        return (array)$resultSet->fetchAllAssociative();
    }

    public function findByDate(\DateTime $start, \DateTime $end): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT * FROM booking b
            WHERE 
            CAST(b.start_time as datetime) >= CAST(:start as datetime) AND
            CAST(b.end_time as datetime) <= CAST(:end as datetime)
            ";
            
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(
            [
                'start' => $start->format('Y-m-d H:i:s'),
                'end' => $end->format('Y-m-d H:i:s'),
            ]
        );

        return (array)$resultSet->fetchAllAssociative();
    }

//    /**
//     * @return Booking[] Returns an array of Booking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Booking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
