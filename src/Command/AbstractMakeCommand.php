<?php
namespace App\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;

 abstract class AbstractMakeCommand extends Command
 {
     const YES = 'Y';
     const No  = 'N';

     protected string $projectDir;
     private Environment $twig;

     public function __construct(string $projectDir,Environment $twig)
     {
         parent::__construct();
         $this->projectDir = $projectDir;
         $this->twig=$twig;
     }

     /**
      * Demande à l'utilisateur de choisir un domaine.
      */
     protected function askDomain(SymfonyStyle $io): string
     {
         // On construit la liste utilisé pour l'autocompletion
         $domains = [];
         $files   = (new Finder())->in("{$this->projectDir}/src/Domain")->depth(0)->directories();

         /** @var SplFileInfo $file */
         foreach ($files as $file) {
             $domains[] = $file->getBasename();
         }

         // On pose à l'utilisateur la question
         $q = new Question('Sélectionner un domaine');
         $q->setAutocompleterValues($domains);

         return $io->askQuestion($q);
     }

     /**
      * Demande à l'utilisateur de  créer ou choisir une entity.
      */
     protected function askEntity(SymfonyStyle $io, string $domain): string
     {
         $finder     = new Finder();
         $filesystem = new Filesystem();
         if (!$filesystem->exists("{$this->projectDir}/src/Domain/{$domain}")) {
             $question = new Question('domain name not found Do you Create '.self::YES.'/'.self::No.'?');
             $reponse  =$io->askQuestion($question);
             if (self::No === mb_strtoupper($reponse)) {
                 exit();
             }
             $filesystem->mkdir("{$this->projectDir}/src/Domain/{$domain}");
         }
         if (!$filesystem->exists("{$this->projectDir}/src/Domain/{$domain}/Entity")) {
             $filesystem->mkdir("{$this->projectDir}/src/Domain/{$domain}/Entity");
         }
         $files   = $finder->in("{$this->projectDir}/src/Domain/{$domain}/Entity");
         $entities=[];
         /** @var SplFileInfo $file */
         foreach ($files as $file) {
             $entities[] = str_replace('.php', '', $file->getBasename());
         }
         // On pose à l'utilisateur la question
         $q = new Question('Creee ou Sélectionner une entity');
         $q->setAutocompleterValues($entities);

         return $io->askQuestion($q);
     }
     protected function createController($io,$domain,$entity){
        $cruds=[$entity,'Create'.$entity,'Update'.$entity];
        $filesystem = new Filesystem();
        $basePath = $this->projectDir.'/src/Http/Controller/'.$entity;
        if (!$filesystem->exists($basePath)) {
            $filesystem->mkdir($basePath);
        }
      
        foreach($cruds as $crud){
            $params = [
                'namespace' => $entity,
                'class_name' => $crud.'Controller'
            ];
            $content = $this->twig->render("@maker/controller.twig", $params);
            $filename  = $this->projectDir.'/src/Http/Controller/'.$entity.'/'.$params['class_name'];
            $directory = dirname($filename);
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            file_put_contents($filename, $content);
        }
     }
     protected function createFile(string $template, array $params, string $output){
        $content = $this->twig->render("@maker/$template.twig", $params);

     }
 }