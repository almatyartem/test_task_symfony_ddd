<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Loan;
use App\Domain\Repository\LoanRepositoryInterface;

class InMemoryLoanRepository implements LoanRepositoryInterface
{
    /**
     * @var Loan[]
     */
    private array $loans = [];

    public function add(Loan $loan): void
    {
        $this->loans[] = $loan;
    }

    public function findAll(): array
    {
        return $this->loans;
    }
}
