<?php

namespace App\Infrastructure\Notification;

use App\Application\Service\Contract\NotificationServiceInterface;
use App\Domain\Entity\Client;

class SmsNotificationService implements NotificationServiceInterface
{
    public function send(Client $client, string $message): bool
    {
        $phone = $client->getPhone();
        //TODO

        return true;
    }
}
