<?php

namespace App\Entity;

use App\Enum\CalculatorStatus;
use App\Repository\CalculatorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CalculatorRepository::class)]
class Calculator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[Assert\Length(
        max: 255,
        maxMessage: 'Ce texte ne peut dépasser {{ limit }} caractères.',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(length: 255)]
    private ?CalculatorStatus $status = null;

    /**
     * @var Collection<int, AccountingEntry>
     */
    #[ORM\OneToMany(targetEntity: AccountingEntry::class, mappedBy: 'calculator')]
    private Collection $accountingEntries;

    /**
     * @var Collection<int, MaintenanceOperation>
     */
    #[ORM\OneToMany(targetEntity: MaintenanceOperation::class, mappedBy: 'calculator', orphanRemoval: true)]
    private Collection $maintenanceOperations;

    public function __construct()
    {
        $this->accountingEntries = new ArrayCollection();
        $this->maintenanceOperations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getStatus(): ?CalculatorStatus
    {
        return $this->status;
    }

    public function setStatus(CalculatorStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, AccountingEntry>
     */
    public function getAccountingEntries(): Collection
    {
        return $this->accountingEntries;
    }

    public function addAccountingEntry(AccountingEntry $accountingEntry): static
    {
        if (!$this->accountingEntries->contains($accountingEntry)) {
            $this->accountingEntries->add($accountingEntry);
            $accountingEntry->setCalculator($this);
        }

        return $this;
    }

    public function removeAccountingEntry(AccountingEntry $accountingEntry): static
    {
        if ($this->accountingEntries->removeElement($accountingEntry)) {
            // set the owning side to null (unless already changed)
            if ($accountingEntry->getCalculator() === $this) {
                $accountingEntry->setCalculator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MaintenanceOperation>
     */
    public function getMaintenanceOperations(): Collection
    {
        return $this->maintenanceOperations;
    }

    public function addMaintenanceOperation(MaintenanceOperation $maintenanceOperation): static
    {
        if (!$this->maintenanceOperations->contains($maintenanceOperation)) {
            $this->maintenanceOperations->add($maintenanceOperation);
            $maintenanceOperation->setCalculator($this);
        }

        return $this;
    }

    public function removeMaintenanceOperation(MaintenanceOperation $maintenanceOperation): static
    {
        if ($this->maintenanceOperations->removeElement($maintenanceOperation)) {
            // set the owning side to null (unless already changed)
            if ($maintenanceOperation->getCalculator() === $this) {
                $maintenanceOperation->setCalculator(null);
            }
        }

        return $this;
    }
}
