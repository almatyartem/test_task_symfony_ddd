<?php

namespace App\Domain\Entity;

readonly class Loan
{
    private function __construct(
        protected string $name,
        protected int $termInMonths,
        protected float $interestRate,
        protected float $amount
    ){}

    public static function build(string $name, int $termInMonths, float $interestRate, float $amount): Loan
    {
        if ($termInMonths <= 0) {
            throw new \InvalidArgumentException('Term in months must be greater than 0.');
        }

        if ($interestRate < 0) {
            throw new \InvalidArgumentException('Interest rate cannot be negative.');
        }

        if ($amount <= 0) {
            throw new \InvalidArgumentException('Amount must be greater than 0.');
        }

        return new self($name, $termInMonths, $interestRate, $amount);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTermInMonths(): int
    {
        return $this->termInMonths;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
