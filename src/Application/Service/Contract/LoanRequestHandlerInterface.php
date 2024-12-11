<?php

namespace App\Application\Service\Contract;

use App\Domain\Entity\Client;
use App\Domain\Entity\Loan;
use App\Domain\Service\Exception\ConfigurationException;

interface LoanRequestHandlerInterface
{
    /**
     * @throws ConfigurationException
     */
    public function handle(Client $client, string $name, float $amount, int $term): ?Loan;
}
