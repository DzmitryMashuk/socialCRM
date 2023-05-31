<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Service>
 *
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function save(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Service $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Service[] Returns an array of Service objects
     */
    public function findByUserAndServiceDate(int $userId, ?string $serviceDateFrom, ?string $serviceDateTo): array
    {
        $query = $this->createQueryBuilder('s')
            ->andWhere('s.user = :userId')
            ->setParameter('userId', $userId);

        if ($serviceDateFrom) {
            $query
                ->andWhere('s.serviceDate >= :serviceDateFrom')
                ->setParameter('serviceDateFrom', $serviceDateFrom);
        }

        if ($serviceDateTo) {
            $query
                ->andWhere('s.serviceDate <= :serviceDateTo')
                ->setParameter('serviceDateTo', $serviceDateTo);
        }

        $query->orderBy('s.id', 'ASC');

        return $query
            ->getQuery()
            ->getResult();
    }
}
