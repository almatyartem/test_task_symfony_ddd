<?php

namespace App\Domain\Service\Contract;

use App\Domain\Entity\Client;
use App\Domain\Service\Exception\ConfigurationException;

interface EligibilityCheckerInterface
{
    /**
     * @throws ConfigurationException
     */
    public function check(Client $client): bool;

    public function getNonEligibilityExplanation() : string;
}
