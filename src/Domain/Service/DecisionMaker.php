<?php

namespace App\Domain\Service;

use App\Domain\Entity\Client;
use App\Domain\Entity\Loan;
use App\Domain\Service\Contract\DecisionMakerInterface;
use App\Domain\Service\Contract\DecisionParametersInterface;

class DecisionMaker implements DecisionMakerInterface
{
    public function __construct(
        protected DecisionParametersInterface $config
    ) {}

    public function decide(Client $client, Loan $loan): bool
    {
        $chance = $this->config->getStateChance($client->getAddress()->getState())
            ?? $this->config->getDefaultChance();

        return mt_rand(1, 100) <= $chance;
    }
}
