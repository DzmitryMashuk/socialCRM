<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ServiceCatalog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceCatalog>
 *
 * @method ServiceCatalog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceCatalog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceCatalog[]    findAll()
 * @method ServiceCatalog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceCatalogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceCatalog::class);
    }

    public function save(ServiceCatalog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ServiceCatalog $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
