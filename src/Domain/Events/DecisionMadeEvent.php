<?php

namespace App\Domain\Events;

use App\Domain\Entity\Client;

class DecisionMadeEvent
{
    public function __construct(
        protected Client $client,
        protected bool $succeed
    ){}

    public function getClient(): Client
    {
        return $this->client;
    }

    public function isSucceed(): bool
    {
        return $this->succeed;
    }
}
