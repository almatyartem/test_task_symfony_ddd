<?php

namespace App\Interface\Command;

use App\Application\Service\Contract\ClientServiceInterface;
use App\Application\Service\Contract\LoanRequestHandlerInterface;
use App\Domain\Service\EligibilityService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ProcessLoanCommand extends BaseCommand
{
    public function __construct(
        protected ClientServiceInterface $clientService,
        protected LoanRequestHandlerInterface $loanHandler,
        protected EligibilityService $eligibilityChecker,
    ) {
        parent::__construct();
    }

    /**
     * @return string[]
     */
    public static function getFields(): array
    {
        return [
            'clientId' => 'ID клиента',
            'name' => 'Название продукта',
            'termInMonths' => 'Срок кредита',
            'amount' => 'Сумма',
        ];
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $client = $this->clientService->findClient($input->getArgument('clientId'));
            if(!$client) {
                $output->writeln('Client not found');

                return Command::FAILURE;
            }
            if(!$this->eligibilityChecker->isEligible($client)) {
                $output->writeln('Client is not eligible');
            }
            if($this->loanHandler->handle(
                $client,
                $input->getArgument('name'),
                $input->getArgument('amount'),
                $input->getArgument('termInMonths')
            )) {
                $output->writeln("{$client->getFirstName()} {$client->getLastName()} successfully got a loan!");
            } else {
                $output->writeln('Loan was not approved for this client');
            }

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }

    public static function getCommandName(): string
    {
        return 'app:process-loan';
    }

    public function getCommandDescription(): string
    {
        return 'Принятие решения';
    }
}
