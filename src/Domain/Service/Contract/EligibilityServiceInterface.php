<?php

namespace App\Domain\Service\Contract;

use App\Domain\Entity\Client;
use App\Domain\Service\Exception\ConfigurationException;

interface EligibilityServiceInterface
{
    /**
     * @throws ConfigurationException
     */
    public function isEligible(Client $client): bool;

    /**
     * @return string[]|null
     * @throws ConfigurationException
     */
    public function getNonEligibilityReasons(Client $client) : ?array;
}
