<?php
namespace App\Infrastructure\Event;

use App\Domain\Service\Contract\DomainEventPublisherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class SymfonyDomainEventPublisher implements DomainEventPublisherInterface
{
    private EventDispatcherInterface $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function publish(object $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
