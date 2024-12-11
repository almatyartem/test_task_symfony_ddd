<?php
namespace App\Domain\Service\Contract;

use App\Domain\ValueObject\Enum\State;

interface DecisionParametersInterface
{
    public function getStateChance(State $state): ?float;
    public function getDefaultChance(): float;
}
