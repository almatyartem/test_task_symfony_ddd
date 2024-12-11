<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entity\Client;
use App\Domain\Repository\ClientRepositoryInterface;

class InMemoryClientRepository implements ClientRepositoryInterface
{
    /**
     * @var Client[]
     */
    private array $clients = [];

    public function add(Client $client): void
    {
        $this->clients[] = $client;
    }

    public function find(string $id): ?Client
    {
        foreach ($this->clients as $client) {
            if ($client->getId()->toString() === $id) {
                return $client;
            }
        }

        return null;
    }
}
