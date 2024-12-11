<?php

namespace App\Application\Service\Contract;

use App\Domain\Entity\Client;

interface NotificationServiceInterface
{
    public function send(Client $client, string $message): bool;
}
