<?php

namespace App\Application\Service;

use App\Application\Service\Contract\ClientServiceInterface;
use App\Domain\Entity\Client;
use App\Domain\Events\ClientCreatedEvent;
use App\Domain\Repository\ClientRepositoryInterface;
use App\Domain\Service\Contract\DomainEventPublisherInterface;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Enum\State;


class ClientService implements ClientServiceInterface
{
    public function __construct(
        protected ClientRepositoryInterface $repository,
        protected DomainEventPublisherInterface $eventPublisher
    ){}

    public function createClient(
        string $firstName,
        string $lastName,
        int $age,
        string $ssn,
        string $street,
        string $city,
        State $state,
        string $zip,
        int $creditScore,
        string $email,
        string $phone,
        int $income): Client
    {
        $address = Address::build($street, $city, $state, $zip);
        $client = Client::build($firstName, $lastName, $age, $ssn, $address, $creditScore, $email, $phone, $income);

        $this->repository->add($client);
        $this->eventPublisher->publish(new ClientCreatedEvent($client));

        return $client;
    }

    public function findClient(string $ssn): ?Client
    {
        return $this->repository->find($ssn);
    }
}
