<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Client;

interface ClientRepositoryInterface
{
    public function add(Client $client): void;

    public function find(string $id): ?Client;
}
