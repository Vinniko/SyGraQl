<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Tag>
 *
 * @method Tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tag[]    findAll()
 * @method Tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function getStatsByTypeAndBetweenDates(?\DateTime $startDate, ?\DateTime $endDate, ?string $type) {
        $qb = $this->createQueryBuilder('t')
            ->select('t.score');

        if ($startDate && $endDate) {
            $qb
                ->where('t.updated_at >= :startDate')
                ->andWhere('t.updated_at <= :endDate')
                ->setParameter('startDate', $startDate)
                ->setParameter('endDate', $endDate)
            ;
        } elseif ($startDate) {
            $qb
                ->where('t.updated_at >= :startDate')
                ->setParameter('startDate', $startDate)
            ;
        } elseif ($endDate) {
            $qb
                ->where('t.updated_at <= :endDate')
                ->setParameter('startDate', $endDate)
            ;
        }

        if ($type) {
            $qb->andWhere('t.type = :type')
                ->setParameter('type', $type)
            ;
        }

        return $qb->getQuery()->getResult();
    }
}
