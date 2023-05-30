<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceCatalogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceCatalogRepository::class)]
class ServiceCatalog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'serviceCatalog', targetEntity: Service::class)]
    private $services;

    #[ORM\ManyToOne(inversedBy: 'serviceCatalog')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ServiceCatalogGroup $serviceCatalogGroup = null;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function getServiceCatalogGroup(): ?ServiceCatalogGroup
    {
        return $this->serviceCatalogGroup;
    }

    public function setServiceCatalogGroup(?ServiceCatalogGroup $serviceCatalogGroup): self
    {
        $this->serviceCatalogGroup = $serviceCatalogGroup;

        return $this;
    }
}
