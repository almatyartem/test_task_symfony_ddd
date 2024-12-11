<?php

namespace App\Domain\Service;

use App\Domain\Entity\Client;
use App\Domain\Service\Contract\InterestsRateCalculatorInterface;
use App\Domain\Service\Contract\InterestsRateParametersInterface;

class InterestsRateCalculator implements InterestsRateCalculatorInterface
{
    public function __construct(
        protected readonly InterestsRateParametersInterface $config
    ) {}

    public function calculate(Client $client): float
    {
        return $this->config->getDefaultInterestRate() + $this->config->getStateModifier($client->getAddress()->getState());
    }
}
