<?php
namespace App\Domain\Service\Contract;

interface DomainEventPublisherInterface
{
    public function publish(object $event): void;
}
