<?php

namespace App\Domain\Service\Exception;

use Exception;

class ConfigurationException extends Exception
{
    public function __construct(string $class)
    {
        parent::__construct('Configuration error in class '.$class);
    }
}
