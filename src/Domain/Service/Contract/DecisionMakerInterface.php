<?php

namespace App\Domain\Service\Contract;

use App\Domain\Entity\Client;
use App\Domain\Entity\Loan;

interface DecisionMakerInterface
{
    public function decide(Client $client, Loan $loan): bool;
}
