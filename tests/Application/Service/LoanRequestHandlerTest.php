<?php

namespace App\Tests\Application\Service;

use App\Application\Service\LoanRequestHandler;
use App\Domain\Entity\Client;
use App\Domain\Entity\Loan;
use App\Domain\Repository\LoanRepositoryInterface;
use App\Domain\Service\Contract\DecisionMakerInterface;
use App\Domain\Service\Contract\EligibilityServiceInterface;
use App\Domain\Service\Contract\InterestsRateCalculatorInterface;
use PHPUnit\Framework\TestCase;

class LoanRequestHandlerTest extends TestCase
{
    public function testHandleEligibleClientApproved(): void
    {
        $repository = $this->createMock(LoanRepositoryInterface::class);
        $repository->expects($this->once())->method('add')->with($this->isInstanceOf(Loan::class));

        $eligibility = $this->createMock(EligibilityServiceInterface::class);
        $eligibility->method('isEligible')->willReturn(true);

        $decisionMaker = $this->createMock(DecisionMakerInterface::class);
        $decisionMaker->method('decide')->willReturn(true);

        $rateCalculator = $this->createMock(InterestsRateCalculatorInterface::class);
        $rateCalculator->method('calculate')->willReturn(5.5);

        $handler = new LoanRequestHandler($repository, $eligibility, /* eventPublisher */ $this->createMock(\App\Domain\Service\Contract\DomainEventPublisherInterface::class), $rateCalculator, $decisionMaker);

        $client = $this->createMock(Client::class);

        $loan = $handler->handle($client, 'Personal Loan', 10000, 12);
        $this->assertInstanceOf(Loan::class, $loan);
        $this->assertEquals(5.5, $loan->getInterestRate());
    }

    public function testHandleNonEligibleClient(): void
    {
        $repository = $this->createMock(LoanRepositoryInterface::class);
        $repository->expects($this->never())->method('add');

        $eligibility = $this->createMock(EligibilityServiceInterface::class);
        $eligibility->method('isEligible')->willReturn(false);

        $decisionMaker = $this->createMock(DecisionMakerInterface::class);
        $decisionMaker->expects($this->never())->method('decide');

        $rateCalculator = $this->createMock(InterestsRateCalculatorInterface::class);
        $rateCalculator->expects($this->never())->method('calculate');

        $handler = new LoanRequestHandler(
            $repository,
            $eligibility,
            $this->createMock(\App\Domain\Service\Contract\DomainEventPublisherInterface::class),
            $rateCalculator,
            $decisionMaker
        );

        $client = $this->createMock(Client::class);

        $loan = $handler->handle($client, 'Personal Loan', 10000, 12);
        $this->assertNull($loan);
    }
}
