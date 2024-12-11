<?php

namespace App\Interface\Command;

use App\Application\Service\Contract\ClientServiceInterface;
use App\Domain\ValueObject\Enum\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends BaseCommand
{
    public function __construct(
        protected ClientServiceInterface $clientService
    ){
        parent::__construct();
    }

    /**
     * @return string[]
     */
    public static function getFields(): array
    {
        return [
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'age' => 'Возраст',
            'ssn' => 'SSN (социальный страховой номер)',
            'street' => 'Адрес',
            'city' => 'City',
            'state' => 'Штат',
            'zip' => 'ZIP code',
            'creditScore' => 'Кредитный рейтинг FICO',
            'email' => 'Email',
            'phone' => 'Номер телефона',
            'income' => 'Ежемесячный доход',
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stateValue = $input->getArgument('state');
        $state = State::tryFrom($stateValue);
        if (null === $state) {
            $output->writeln("Error: Invalid state code '$stateValue'");
            return Command::FAILURE;
        }

        try {
            $client = $this->clientService->createClient(
                $input->getArgument('firstName'),
                $input->getArgument('lastName'),
                (int) $input->getArgument('age'),
                $input->getArgument('ssn'),
                $input->getArgument('street'),
                $input->getArgument('city'),
                $state,
                $input->getArgument('zip'),
                (int) $input->getArgument('creditScore'),
                $input->getArgument('email'),
                $input->getArgument('phone'),
                (int) $input->getArgument('income')
            );
            $output->writeln('Client successfully created! Id: ' . $client->getId());

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }

    public static function getCommandName(): string
    {
        return 'app:create-client';
    }

    public function getCommandDescription(): string
    {
        return 'Создание нового клиента';
    }
}
