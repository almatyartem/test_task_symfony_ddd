<?php

namespace App\Domain\Service\EligibilityCheckers;

use App\Domain\Entity\Client;
use App\Domain\Service\Contract\EligibilityCheckerInterface;
use App\Domain\Service\Exception\ConfigurationException;

class AgeChecker extends BaseChecker implements EligibilityCheckerInterface
{
    public function check(Client $client): bool
    {
        $minimumAge = $this->getMinimumAge();
        $maximumAge = $this->getMaximumAge();

        if(!$minimumAge || !$maximumAge) {
            throw new ConfigurationException(__CLASS__);
        }

        return $client->getAge() >= $minimumAge && $client->getAge() <= $maximumAge;
    }

    protected function getMinimumAge(): int
    {
        return $this->params->get('eligibility.min_age');
    }

    protected function getMaximumAge(): int
    {
        return $this->params->get('eligibility.max_age');
    }
}
