<?php
namespace App\Infrastructure\Config;

use App\Domain\Service\Contract\InterestsRateParametersInterface;
use App\Domain\ValueObject\Enum\State;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ParameterBagInterestsRateParameters implements InterestsRateParametersInterface
{
    public function __construct(private ParameterBagInterface $params) {}

    public function getDefaultInterestRate(): float
    {
        $rate = $this->params->get('loan.default_interest_rate');
        return is_numeric($rate) ? (float)$rate : 0.0;
    }

    public function getStateModifier(State $state): float
    {
        $modifier = $this->params->get('loan.state_interests_rate_modifiers')[$state->value] ?? null;
        return is_numeric($modifier) ? (float)$modifier : 0.0;
    }
}
