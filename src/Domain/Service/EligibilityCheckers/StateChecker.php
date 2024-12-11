<?php

namespace App\Domain\Service\EligibilityCheckers;

use App\Domain\Entity\Client;
use App\Domain\Service\Contract\EligibilityCheckerInterface;
use App\Domain\Service\Exception\ConfigurationException;

class StateChecker extends BaseChecker implements EligibilityCheckerInterface
{
    public function check(Client $client): bool
    {
        $eligibleStates = $this->getEligibleStates();
        if(!$eligibleStates) {
            throw new ConfigurationException(__CLASS__);
        }

        return in_array($client->getAddress()->getState()->value, $this->getEligibleStates());
    }

    /**
     * @return string[]
     */
    protected function getEligibleStates(): array
    {
        return $this->params->get('eligibility.eligible_states') ?? [];
    }
}
