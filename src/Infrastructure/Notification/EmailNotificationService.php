<?php

namespace App\Infrastructure\Notification;

use App\Application\Service\Contract\NotificationServiceInterface;
use App\Domain\Entity\Client;

class EmailNotificationService implements NotificationServiceInterface
{
    public function send(Client $client, string $message): bool
    {
        $email = $client->getEmail();
        //TODO

        return true;
    }
}
