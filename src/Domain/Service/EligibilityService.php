<?php

namespace App\Domain\Service;

use App\Domain\Entity\Client;
use App\Domain\Service\Contract\EligibilityCheckerInterface;
use App\Domain\Service\Contract\EligibilityServiceInterface;
use App\Domain\Service\Exception\ConfigurationException;

class EligibilityService implements EligibilityServiceInterface
{
    /**
     * @param EligibilityCheckerInterface[] $checkers
     */
    public function __construct(
        protected iterable $checkers
    ){}

    /**
     * @throws ConfigurationException
     */
    public function isEligible(Client $client): bool
    {
        /**
         * @var EligibilityCheckerInterface $checker
         */
        foreach ($this->checkers as $checker) {
            if(!$checker->check($client)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string[]|null
     * @throws ConfigurationException
     */
    public function getNonEligibilityReasons(Client $client) : ?array
    {
        $reasons = [];
        /**
         * @var EligibilityCheckerInterface $checker
         */
        foreach($this->checkers as $checker){
            if(!$checker->check($client)) {
                $reasons[] = $checker->getNonEligibilityExplanation();
            }
        }

        return $reasons ?: null;
    }
}
