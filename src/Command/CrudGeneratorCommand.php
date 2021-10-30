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
    protected static $defaultName = 'next:crud';
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
        $isCrud=$this->verfiyCrud($io,$domain,$entity);
        //probleme deux att
        if ($isCrud){
            $fields  = $this->askAttributes($io, $domain, $entity);
            $this->createTemplate($io, $domain, $entity, $fields);
            $this->createButtonOption($io, $domain, $entity);
            $this->createController($io, $domain, $entity);
            $this->createFormType($io, $domain, $entity, $fields);
            $this->creatJSFile($io, $domain, $entity, $fields);
            $io->comment('ajoute le script dans le fichier Container.ts');
            $io->info("import ".$entity."Service from './Domain/".ucfirst($entity)."/".strtolower($entity).".service'");
            $io->info("container.bind<".ucfirst($entity)."Service>(".ucfirst($entity)."Service).toSelf()");
            $io->comment('ajoute le script dans le fichier webpack.config.js ');
            $io->info(".addEntry('".$this->slugify($entity)."', './assets/Domain/".ucfirst($entity)."/index.ts')");
            $io->info(" php bin/console fos:js-routing:dump --format=json --target=public/js/fos_js_routes.json");
            $io->info("yarn encore dev");
            $io->success('CRUD a bien été créé');
        }
        return Command::SUCCESS;
    }
}
