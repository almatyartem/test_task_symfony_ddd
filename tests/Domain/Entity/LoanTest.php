<?php

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\Loan;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LoanTest extends TestCase
{
    public function testBuildValidLoan(): void
    {
        $loan = Loan::build('Personal Loan', 12, 5.5, 10000);
        $this->assertSame('Personal Loan', $loan->getName());
        $this->assertSame(12, $loan->getTermInMonths());
        $this->assertSame(5.5, $loan->getInterestRate());
        $this->assertSame(10000.0, $loan->getAmount());
    }

    public function testBuildInvalidTerm(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Loan::build('Personal Loan', 0, 5.5, 10000);
    }

    public function testBuildInvalidAmount(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Loan::build('Personal Loan', 12, 5.5, -100);
    }
}
