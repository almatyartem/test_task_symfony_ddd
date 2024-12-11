<?php

namespace App\Application\Service;

use App\Application\Service\Contract\LoanRequestHandlerInterface;
use App\Domain\Entity\Client;
use App\Domain\Entity\Loan;
use App\Domain\Events\DecisionMadeEvent;
use App\Domain\Repository\LoanRepositoryInterface;
use App\Domain\Service\Contract\DecisionMakerInterface;
use App\Domain\Service\Contract\DomainEventPublisherInterface;
use App\Domain\Service\Contract\EligibilityServiceInterface;
use App\Domain\Service\Contract\InterestsRateCalculatorInterface;
use App\Domain\Service\Exception\ConfigurationException;

class LoanRequestHandler implements LoanRequestHandlerInterface
{
    public function __construct(
        protected LoanRepositoryInterface $repository,
        protected EligibilityServiceInterface $eligibilityChecker,
        protected DomainEventPublisherInterface $eventPublisher,
        protected InterestsRateCalculatorInterface $interestsRateCalculator,
        protected DecisionMakerInterface $decisionMaker
    ){}

    /**
     * @throws ConfigurationException
     */
    public function handle(Client $client, string $name, float $amount, int $term): ?Loan
    {
        if (!$this->eligibilityChecker->isEligible($client)) {
            return null;
        }

        $interestRate = $this->calculateInterestRate($client);
        $loan = Loan::build($name, $term, $interestRate, $amount);

        $accepted = $this->decisionMaker->decide($client, $loan);

        if($accepted){
            $this->repository->add($loan);
        }

        $this->eventPublisher->publish(new DecisionMadeEvent($client, $accepted));

        return $accepted ? $loan : null;
    }

    protected function calculateInterestRate(Client $client): float
    {
        return $this->interestsRateCalculator->calculate($client);
    }
}
