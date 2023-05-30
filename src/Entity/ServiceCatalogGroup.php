<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceCatalogGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceCatalogGroupRepository::class)]
class ServiceCatalogGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'serviceCatalogGroup', targetEntity: ServiceCatalog::class, orphanRemoval: true)]
    private Collection $serviceCatalogs;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function __construct()
    {
        $this->serviceCatalogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, ServiceCatalog>
     */
    public function getServiceCatalogs(): Collection
    {
        return $this->serviceCatalogs;
    }

    public function addServiceCatalog(ServiceCatalog $serviceCatalog): self
    {
        if (!$this->serviceCatalogs->contains($serviceCatalog)) {
            $this->serviceCatalogs->add($serviceCatalog);
            $serviceCatalog->setServiceCatalogGroup($this);
        }

        return $this;
    }

    public function removeServiceCatalog(ServiceCatalog $serviceCatalog): self
    {
        if ($this->serviceCatalogs->removeElement($serviceCatalog)) {
            if ($serviceCatalog->getServiceCatalogGroup() === $this) {
                $serviceCatalog->setServiceCatalogGroup(null);
            }
        }

        return $this;
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
}
