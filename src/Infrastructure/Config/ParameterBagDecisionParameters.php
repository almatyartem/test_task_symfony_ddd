<?php
namespace App\Infrastructure\Config;

use App\Domain\Service\Contract\DecisionParametersInterface;
use App\Domain\ValueObject\Enum\State;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ParameterBagDecisionParameters implements DecisionParametersInterface
{
    public function __construct(
        protected ParameterBagInterface $params
    ) {}

    public function getStateChance(State $state): ?float
    {
        $value = $this->params->get('decision.state_chances')[$state->value] ?? null;

        return is_numeric($value) ? (float)$value : null;
    }

    public function getDefaultChance(): float
    {
        $value = $this->params->get('decision.default_chance');

        return is_numeric($value) ? (float)$value : 100;
    }
}
