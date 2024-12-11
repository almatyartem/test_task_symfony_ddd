<?php
namespace App\Domain\Service\Contract;

use App\Domain\ValueObject\Enum\State;

interface InterestsRateParametersInterface
{
    public function getDefaultInterestRate(): float;
    public function getStateModifier(State $state): float;
}
