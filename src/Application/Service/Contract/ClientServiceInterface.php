<?php

namespace App\Application\Service\Contract;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Enum\State;

interface ClientServiceInterface
{
    public function createClient(
        string $firstName,
        string $lastName,
        int $age,
        string $ssn,
        string $street,
        string $city,
        State $state,
        string $zip,
        int $creditScore,
        string $email,
        string $phone,
        int $income): Client;

    public function findClient(string $ssn): ?Client;
}
