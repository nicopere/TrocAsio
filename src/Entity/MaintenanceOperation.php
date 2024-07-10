<?php

namespace App\Entity;

use App\Repository\MaintenanceOperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaintenanceOperationRepository::class)]
class MaintenanceOperation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(length: 255)]
    private ?string $action = null;

    #[ORM\ManyToOne(inversedBy: 'maintenanceOperations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Calculator $calculator = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getCalculator(): ?Calculator
    {
        return $this->calculator;
    }

    public function setCalculator(?Calculator $calculator): static
    {
        $this->calculator = $calculator;

        return $this;
    }
}
