<?php

namespace App\Entity;

use App\Repository\AccountingEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AccountingEntryRepository::class)]
#[UniqueEntity(['receiptNumber'])]
class AccountingEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\ManyToOne(inversedBy: 'accountingEntries')]
    private ?Calculator $calculator = null;

    #[Assert\Positive]
    #[ORM\Column(nullable: true)]
    private ?int $receiptNumber = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\Length(
        max: 255,
        maxMessage: 'Ce texte ne peut dépasser {{ limit }} caractères.',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $furtherInformation = null;

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

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

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

    public function getReceiptNumber(): ?int
    {
        return $this->receiptNumber;
    }

    public function setReceiptNumber(?int $receiptNumber): static
    {
        $this->receiptNumber = $receiptNumber;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFurtherInformation(): ?string
    {
        return $this->furtherInformation;
    }

    public function setFurtherInformation(?string $furtherInformation): static
    {
        $this->furtherInformation = $furtherInformation;

        return $this;
    }
}
