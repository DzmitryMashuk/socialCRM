<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $middle_name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(type: 'integer')]
    private ?int $age = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $guardian_name = null;

    #[ORM\Column(length: 25, nullable: true)]
    private ?string $guardian_phone = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'clients')]
    private UserInterface $user;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Service::class)]
    private $services;

    #[ORM\Column(type: 'json')]
    private array $visit_days = [];

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middle_name;
    }

    public function setMiddleName(string $middle_name): self
    {
        $this->middle_name = $middle_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGuardianName(): ?string
    {
        return $this->guardian_name;
    }

    public function setGuardianName(?string $guardian_name): self
    {
        $this->guardian_name = $guardian_name;

        return $this;
    }

    public function getGuardianPhone(): ?string
    {
        return $this->guardian_phone;
    }

    public function setGuardianPhone(?string $guardian_phone): self
    {
        $this->guardian_phone = $guardian_phone;

        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    /**
     * @return int[]
     */
    public function getVisitDays(): array
    {
        return $this->visit_days;
    }

    /**
     * @param int[] $visit_days
     */
    public function setVisitDays(array $visit_days): self
    {
        $this->visit_days = $visit_days;

        return $this;
    }

    public function getFullName(): string
    {
        return sprintf('%s %s %s', $this->getFirstName(), $this->getMiddleName(), $this->getLastName());
    }
}
