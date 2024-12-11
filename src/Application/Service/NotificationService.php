<?php

namespace App\Application\Service;

use App\Application\Service\Contract\NotificationServiceInterface;
use App\Domain\Entity\Client;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @param NotificationServiceInterface[] $senders
     */
    public function __construct(protected iterable $senders){}
    public function send(Client $client, string $message): bool
    {
        /**
         * @var NotificationServiceInterface $sender
         */
        foreach ($this->senders as $sender) {
            if($sender->send($client, $message)){
                return true;
            }
        }

        return false;
    }
}
