<?php

namespace App\Interface\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class BaseCommand extends Command
{
    protected function configure()
    {
        $this->setName($this->getCommandName());
        $this->setDescription($this->getCommandDescription());

        foreach(static::getFields() as $field => $title) {
            $this->addArgument($field, InputArgument::REQUIRED, $title);
        }
    }

    /**
     * @return string[]
     */
    public static function getFields(): array
    {
        return [];
    }

    public static abstract function getCommandName(): string;

    public abstract function getCommandDescription(): string;
}
