<?php

namespace App\Command;

use App\Domain\User\Service\PermessionService;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class MakePermissionsCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'next:load-permissions';
    private PermessionService $permessionService;

    public function __construct(string $projectDir, Environment $twig, Filesystem $filesystem,PermessionService $permessionService)
    {
        parent::__construct($projectDir, $twig, $filesystem);
        $this->permessionService = $permessionService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Load New permissions ')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->permessionService->savePermission();
        return Command::SUCCESS;
    }
}