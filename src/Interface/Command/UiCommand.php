<?php

namespace App\Interface\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UiCommand extends BaseCommand
{
    /**
     * @var string[]
     */
    protected array $commands;

    private SymfonyStyle $io;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commands = [
            'Create Client' => CreateClientCommand::getCommandName(),
            'Check Eligibility' => CheckEligibilityCommand::getCommandName(),
            'Process Loan' => ProcessLoanCommand::getCommandName(),
            'Exit' => 'exit'
        ];

        $this->io = new SymfonyStyle($input, $output);
        $this->io->title('CLI UI for command execution started.');

        // @phpstan-ignore-next-line
        while (true) {
            $this->io->section('Waiting for user input...');
            $this->askForCommand();
        }
        // @phpstan-ignore-next-line
        return Command::SUCCESS;
    }

    private function askForCommand(): void
    {
        $question = new ChoiceQuestion(
            'Choose a command to execute:',
            array_keys($this->commands),
            0
        );
        $question->setErrorMessage('Command %s is invalid.');

        $commandChoice = $this->io->askQuestion($question);

        switch ($commandChoice) {
            case 'Create Client':
                $this->createClient();
                break;

            case 'Check Eligibility':
                $this->checkEligibility();
                break;

            case 'Process Loan':
                $this->processLoan();
                break;

            case 'Exit':
                $this->io->note('Exiting the process...');
                exit(0);

            default:
                $this->io->error('Invalid command selected. Try again.');
        }
    }

    protected function createClient(): void
    {
        $this->runCommand($this->commands['Create Client'], CreateClientCommand::getFields());
    }

    protected function checkEligibility(): void
    {
        $this->runCommand($this->commands['Check Eligibility'], CheckEligibilityCommand::getFields());
    }

    protected function processLoan(): void
    {
        $this->runCommand($this->commands['Process Loan'], ProcessLoanCommand::getFields());
    }

    /**
     * @param string $commandName
     * @param string[] $fields
     */
    protected function runCommand(string $commandName, array $fields): void
    {
        $args = array_map(function ($description) {
            return $this->io->ask($description);
        }, $fields);
        $input = new ArrayInput(array_merge([$commandName], $args));
        $command = $this->getApplication()->find($commandName);
        $command->run($input, $this->io);
    }

    public static function getCommandName(): string
    {
        return 'app:ui';
    }

    public function getCommandDescription(): string
    {
        return 'A long-running process that runs continuously and executes commands based on user input.';
    }
}
