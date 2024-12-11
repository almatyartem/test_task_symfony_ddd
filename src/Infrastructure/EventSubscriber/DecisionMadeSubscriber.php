<?php

namespace App\Infrastructure\EventSubscriber;

use App\Application\Service\NotificationService;
use App\Domain\Events\DecisionMadeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class DecisionMadeSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected NotificationService $notificationService
    ){}

    public static function getSubscribedEvents(): array
    {
        return [
            DecisionMadeEvent::class => 'onDecisionMade',
        ];
    }

    public function onDecisionMade(DecisionMadeEvent $event): void
    {
        $client = $event->getClient();
        $accepted = $event->isSucceed();

        $message = $accepted
            ? "Congratulations, your loan has been approved!"
            : "We are sorry, your loan request was not approved at this time.";

        $this->notificationService->send($client, $message);
    }
}
