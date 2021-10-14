<?php

namespace App\Command;

use App\Domain\Settings\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SettingsCommand extends Command
{


    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var SettingsRepository
     */
    private SettingsRepository $settingsRepository;
    public $settings=[];
    public function __construct(string $name = null, EntityManagerInterface $manager , SettingsRepository $settingsRepository)
    {
        parent::__construct();
        $this->settings=["app.settings.lang","app.settings.name","app.mail.smtp.name","app.mail.smtp.password",
                         "app.mail.smtp.username","app.mail.smtp.encryption","app.mail.smtp.port","app.mail.smtp.host","app.mail.address.email"];
        $this->manager = $manager;
        $this->settingsRepository = $settingsRepository;
    }
    protected static $defaultName = 'next:settings';
    protected static $defaultDescription = 'Add or create new item in settings';
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');
        return Command::SUCCESS;
    }
}
