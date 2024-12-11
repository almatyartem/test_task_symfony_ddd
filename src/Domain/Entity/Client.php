<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Address;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

readonly class Client
{
    private function __construct(
        protected UuidV4 $id,
        protected string $firstName,
        protected string $lastName,
        protected int $age,
        protected string $ssn,
        protected Address $address,
        protected int $creditScore,
        protected string $email,
        protected string $phone,
        protected int $income
    ) {}

    public static function build(
        string $firstName,
        string $lastName,
        int $age,
        string $ssn,
        Address $address,
        int $creditScore,
        string $email,
        string $phone,
        int $income
    ): Client {

        if ($age < 0) {
            throw new InvalidArgumentException('Age must be > 0');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email address.');
        }

        if (!preg_match('/^\d{9}$/', $ssn)) {
            throw new InvalidArgumentException('SSN must be a 9-digit number.');
        }

        return new self(
            Uuid::v4(),
            trim($firstName),
            trim($lastName),
            $age,
            preg_replace('/\D/', '', $ssn),
            $address,
            $creditScore,
            strtolower(trim($email)),
            preg_replace('/\D/', '', $phone),
            $income
        );
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getCreditScore(): int
    {
        return $this->creditScore;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getIncome(): int
    {
        return $this->income;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getSsn(): string
    {
        return $this->ssn;
    }
}
