<?php

namespace App\Command;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class DeleteUserCommand extends AbstractMakeCommand
{
    protected static $defaultName = 'next:delete-user';

    private $io;
    private $entityManager;
    private $users;
    public function __construct(string $projectDir, Environment $twig, Filesystem $filesystem,EntityManagerInterface $em, UserRepository $users)
    {
        parent::__construct($projectDir, $twig, $filesystem);
        $this->entityManager = $em;
        $this->users = $users;
    }
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Deletes users from the database')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of an existing user')
            ->setHelp(<<<'HELP'
The <info>%command.name%</info> command deletes users from the database:
  <info>php %command.full_name%</info> <comment>username</comment>
If you omit the argument, the command will ask you to
provide the missing value:
  <info>php %command.full_name%</info>
HELP
            );
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (null !== $input->getArgument('username')) {
            return;
        }

        $this->io->title('Delete User Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, provide the',
            'arguments required by this command as follows:',
            '',
            ' $ php bin/console app:delete-user username',
            '',
            'Now we\'ll ask you for the value of all the missing command arguments.',
            '',
        ]);

        $username = $this->io->ask('Username', null, [$this->validator, 'validateUsername']);
        $input->setArgument('username', $username);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        /** @var User|null $user */
        $user = $this->users->findOneByEmail($username);
        if (null === $user) {
            throw new \Exception(sprintf('User with username "%s" not found.', $username));
        }
        $userId = $user->getId();
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        $this->io->success(sprintf('User "%s" (ID: %d, email: %s) was successfully deleted.', $user->getEmail(), $userId, $user->getEmail()));
        return Command::SUCCESS;
    }

}