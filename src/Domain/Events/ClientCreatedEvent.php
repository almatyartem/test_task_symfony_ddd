<?php

namespace App\Domain\Events;

use App\Domain\Entity\Client;

class ClientCreatedEvent
{
    public function __construct(
        protected Client $client,
    ){}

    public function getClient(): Client
    {
        return $this->client;
    }
}
