<?php
namespace App\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
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
     protected function askAttributes(SymfonyStyle $io,$domain,$entity):array{
        $attrubutis=$this->getProperties($domain,$entity);
        $q = new Question('Sélectionner une Properties');
        $q->setAutocompleterValues($attrubutis);
        $result[]=$io->askQuestion($q);
        while(true){
            $qs = new Question('Sélectionner une autre Propertie '.self::YES.'/'.self::No.'?');
            $reponse  =$io->askQuestion($qs);
            if (self::No === mb_strtoupper($reponse)) {
                return $result;
            }
            $q = new Question('Sélectionner une Properties');
            $q->setAutocompleterValues($attrubutis);
            $result[]=$io->askQuestion($q);
            
        }
         
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
        $paths=[
            ['class'=>$entity,'route'=>"/".strtolower($entity),'route_name'=>strtolower($entity)],
            ['class'=>'Create'.$entity,'route'=>"/".strtolower($entity).'/create','route_name'=>strtolower($entity).'_create'],
            ['class'=>'Update'.$entity,'route'=>"/".strtolower($entity).'/update/{id}','route_name'=>strtolower($entity).'_update']
        ];

        $filesystem = new Filesystem();
        $basePath = $this->projectDir.'/src/Http/Controller/'.$entity;
        if (!$filesystem->exists($basePath)) {
            $filesystem->mkdir($basePath);
        }
    
        foreach($paths as $path){

            $params = [
                'namespace' => $path['class'],
                'class_name' => $path['class'].'Controller',
                'route' => $path['route'],
                'route_name' => $path['route_name']

            ];
            $output  = $this->projectDir.'/src/Http/Controller/'.$entity.'/'.$params['class_name'];
            $this->createFile('controller',$params,$output);
        }
     }
     protected function createTemplate($io,$domain,$entity,$properties){
        $paths=[
            ['template'=>'index'],
            ['template'=>'create'],
            ['template'=>'edit'],
            ['template'=>'_form'],
        ];
        $filesystem = new Filesystem();
        $basePath = $this->projectDir.'/templates/'.$domain.'/'.$this->slugify($entity);
        if (!$filesystem->exists($basePath)) {
            $filesystem->mkdir($basePath);
        }
        foreach($paths as $path){
            $params = [
                'label'=>$entity,
                "id_table"=>$this->slugify($entity)."_table",
                "properties"=>$properties
            ];
            $output  = $basePath.'/'.$path['template'];
            $this->createFile("admin/".$path['template'].".html",$params,$output.'.html.twig');
        }
     }
     protected function createFormType($io,$domain,$entity,$properties){
        $filesystem = new Filesystem();
        $params = [
            'domain'=>$domain,
            "entity"=>$entity,
            "properties"=>$properties
        ];
        $basePath = $this->projectDir.'/src/Domain/'.$domain.'/Form';
        $this->createFile("form/FormType.php",$params,$basePath.'/'.$entity.'Type.php');

     }
     protected function createFile(string $template, array $params, string $output): void
     {
        
         $content = $this->twig->render("@maker/$template.twig", $params);
         $directory = dirname($output);
         if (!file_exists($directory)) {
             mkdir($directory, 0777, true);
         }
         file_put_contents($output, $content);
     }
     function slugify($str){
        $strings = preg_split('/(?=[A-Z])/',$str);
        array_shift($strings);
        $string="";
        foreach ($strings as $key=>$s ){
            $separteur=(count($strings)-1>$key)?'_':'';
            $string.=strtolower($s).$separteur;
        }
       return $string;
     }
     protected function getProperties (string $domain, string $entity): array{
        $reflectionExtractor = new ReflectionExtractor();
        return $reflectionExtractor->getProperties("App\\Domain\\".$domain."\\Entity\\".$entity);
     }
 }