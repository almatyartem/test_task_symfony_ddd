<?php

namespace App\Domain\ValueObject;

use App\Domain\ValueObject\Enum\State;

readonly class Address
{
    private function __construct(
        protected string $street,
        protected string $city,
        protected State $state,
        protected string $zip
    ){}

    public static function build(string $street, string $city, State $state, string $zip) : Address
    {
        return new Address(
            trim($street),
            trim($city),
            $state,
            trim($zip)
        );
    }

    public function getState(): State
    {
        return $this->state;
    }
}
