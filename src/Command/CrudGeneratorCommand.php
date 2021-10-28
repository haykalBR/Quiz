<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Command\AbstractMakeCommand;
use Symfony\Component\Console\Input\ArrayInput;

class CrudGeneratorCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'CrudGenerator';
    protected static $defaultDescription = 'A CRUD generator with datatable pagination.';
    protected function configure(): void
    {
        $this
            ->setDescription(CrudGeneratorCommand::$defaultDescription)
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $domain = $this->askDomain($io);
        $entity = $this->askEntity($io, $domain);
        $attrubutis = $this->askAttributes($io, $domain,$entity);
        $this->createController($io,$domain,$entity);
        $this->createTemplate($io,$domain,$entity,$attrubutis);
        $this->createFormType($io,$domain,$entity,$attrubutis);
        return Command::SUCCESS;
    }
    
}
