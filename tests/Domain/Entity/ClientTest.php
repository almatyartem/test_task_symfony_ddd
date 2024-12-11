<?php

namespace App\Tests\Domain\Entity;

use App\Domain\Entity\Client;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Enum\State;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testBuildValidClient(): void
    {
        $address = Address::build('123 Main St', 'Los Angeles', State::California, '90001');
        $client = Client::build(
            'John',
            'Doe',
            30,
            '123456789',
            $address,
            600,
            'test@example.com',
            '+1-202-555-0147',
            2000
        );

        $this->assertSame('John', $client->getFirstName());
        $this->assertSame('Doe', $client->getLastName());
        $this->assertSame(30, $client->getAge());
        $this->assertSame('123456789', $client->getSsn());
        $this->assertSame(600, $client->getCreditScore());
        $this->assertSame('test@example.com', $client->getEmail());
        $this->assertSame('12025550147', $client->getPhone()); // предположим, что класс чистит телефон от нецифр
        $this->assertSame(2000, $client->getIncome());
        $this->assertEquals($address, $client->getAddress());
    }

    public function testBuildInvalidAge(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $address = Address::build('123 Main St', 'Los Angeles', State::California, '90001');
        Client::build('John', 'Doe', -1, '123456789', $address, 600, 'test@example.com', '+1-202-555-0147', 2000);
    }

    public function testBuildInvalidEmail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $address = Address::build('123 Main St', 'Los Angeles', State::California, '90001');
        Client::build('John', 'Doe', 30, '123456789', $address, 600, 'not-an-email', '+1-202-555-0147', 2000);
    }

    public function testBuildInvalidSsn(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $address = Address::build('123 Main St', 'Los Angeles', State::California, '90001');
        Client::build('John', 'Doe', 30, 'invalid_ssn', $address, 600, 'test@example.com', '+1-202-555-0147', 2000);
    }
}
