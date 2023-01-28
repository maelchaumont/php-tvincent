<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(name: 'print-people')]
class PrintPeopleCommand extends Command
{
    protected function configure()
    {
        $this
            ->setDescription('Print a list of users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $array = Yaml::parseFile('people-list.yaml');
        foreach($array as $value) {
            $output->writeln($value);
        }
        return Command::SUCCESS;
    }
}