<?php

namespace App\Domain\Service\Contract;

use App\Domain\Entity\Client;

interface InterestsRateCalculatorInterface
{
    public function calculate(Client $client): float;
}
