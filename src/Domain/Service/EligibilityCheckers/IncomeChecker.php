<?php

namespace App\Domain\Service\EligibilityCheckers;

use App\Domain\Entity\Client;
use App\Domain\Service\Contract\EligibilityCheckerInterface;
use App\Domain\Service\Exception\ConfigurationException;

class IncomeChecker extends BaseChecker implements EligibilityCheckerInterface
{
    public function check(Client $client): bool
    {
        $minimumIncome = $this->getMinimumIncome();
        if(!$minimumIncome) {
            throw new ConfigurationException(__CLASS__);
        }

        return $client->getIncome() >= $minimumIncome;
    }

    protected function getMinimumIncome(): int
    {
        return $this->params->get('eligibility.min_income');
    }
}
