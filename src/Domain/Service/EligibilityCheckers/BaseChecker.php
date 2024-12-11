<?php

namespace App\Domain\Service\EligibilityCheckers;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class BaseChecker
{
    public function __construct(
        protected ParameterBagInterface $params
    ){}

    public function getNonEligibilityExplanation() : string
    {
        $explanations = $this->params->get('eligibility.non_eligibility_explanation');

        return $explanations[self::getClassName()] ?? $explanations['default'];
    }

    protected static function getClassName(): string
    {
        return basename(str_replace('\\', '/', static::class));
    }
}
