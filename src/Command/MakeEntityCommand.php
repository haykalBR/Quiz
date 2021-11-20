<?php
namespace App\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeEntityCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'next:entity';

    protected function configure(): void
    {
        $this
            ->setDescription('Crée une entité dans le domaine choisi et le test associé')
            ->addArgument('entityName', InputArgument::OPTIONAL, "Nom de l'entité")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $domain = $this->askDomain($io);
        /** @var string $entity */
        $entity = $input->getArgument('entityName');
        $this->correctionDir($domain);


        /** @var Application $application */
        $application = $this->getApplication();
        $command = $application->find('make:entity');
        $arguments = [
            'command' => 'make:entity',
            'name' => "\\App\\Domain\\$domain\\Entity\\$entity",
        ];
        $greetInput = new ArrayInput($arguments);
        $command->run($greetInput, $output);
        return Command::SUCCESS;
    }
}
