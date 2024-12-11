<?php

namespace App\Interface\Command;

use App\Application\Service\Contract\ClientServiceInterface;
use App\Domain\Service\Contract\EligibilityServiceInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class CheckEligibilityCommand extends BaseCommand
{
    /**
     * @return string[]
     */
    public static function getFields(): array
    {
        return [
            'clientId' => 'ID клиента'
        ];
    }

    public function __construct(
        protected ClientServiceInterface $clientService,
        protected EligibilityServiceInterface $checker
    ) {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = $this->clientService->findClient($input->getArgument('clientId'));
        if(!$client) {
            $output->writeln('Client not found');

            return Command::FAILURE;
        }

        try {
            $isEligible = $this->checker->isEligible($client);
            $eligibilityStatus = $isEligible ? 'eligible' : 'not eligible';
            $output->writeln("{$client->getFirstName()} {$client->getLastName()} is $eligibilityStatus for a loan!");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }

    public static function getCommandName(): string
    {
        return 'app:check-eligibility';
    }

    public function getCommandDescription(): string
    {
        return 'Проверка возможности выдачи кредита';
    }
}
