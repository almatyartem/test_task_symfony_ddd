<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Loan;

interface LoanRepositoryInterface
{
    public function add(Loan $loan): void;

    /**
     * @return Loan[]
     */
    public function findAll(): array;
}
