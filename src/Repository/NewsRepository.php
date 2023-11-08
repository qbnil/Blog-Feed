<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;
/**
 * @extends ServiceEntityRepository<News>
 *
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }


/*
 * 1) Find out the length of all news
 * 2) Pick the largest by descending order
 * 3) Return only the new that's on top aka has the largest numbers of chars
 */
    public function getLongestNewAndShortestComm(): array
    {
            return $this->createQueryBuilder('n')
            ->select('n.newsDescription as longest_new')
            ->addSelect('c.commentContent as news_comment')
            ->leftJoin('n.newsComments', 'c')
            ->orderBy('LENGTH(n.newsDescription)', 'DESC')
            ->addOrderBy('LENGTH(c.commentContent)')
            ->setMaxResults('1')
            ->getQuery()
            ->getSingleResult();
    }



    public function getNewsForGivenPeriod(DateTime $timeFrom): array {
        return $this->createQueryBuilder('n')
            ->select('n.newsDescription')
            ->andWhere('n.createdAtDateAndTime >= :time_from')
            ->setParameter('time_from', $timeFrom)
            ->getQuery()
            ->getSingleColumnResult();
    }
//    /**
//     * @return News[] Returns an array of News objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?News
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
