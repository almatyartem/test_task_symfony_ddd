<?php

namespace App\Domain\Service\EligibilityCheckers;

use App\Domain\Entity\Client;
use App\Domain\Service\Contract\EligibilityCheckerInterface;
use App\Domain\Service\Exception\ConfigurationException;

class CreditScoreChecker extends BaseChecker implements EligibilityCheckerInterface
{
    public function check(Client $client): bool
    {
        $minimumCreditScore = $this->getMinimumCreditScore();
        if(!$minimumCreditScore) {
            throw new ConfigurationException(__CLASS__);
        }

        return $client->getCreditScore() >= $minimumCreditScore;
    }

    protected function getMinimumCreditScore(): int
    {
        return $this->params->get('eligibility.min_credit_score');
    }
}
