<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ServiceCatalogGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceCatalogGroup>
 *
 * @method ServiceCatalogGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceCatalogGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceCatalogGroup[]    findAll()
 * @method ServiceCatalogGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceCatalogGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceCatalogGroup::class);
    }

    public function save(ServiceCatalogGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ServiceCatalogGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
