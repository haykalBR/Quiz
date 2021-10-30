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
    const NO  = 'N';

    protected string $projectDir;
    private Environment $twig;
    private Filesystem $filesystem;


    public function __construct(string $projectDir, Environment $twig, Filesystem  $filesystem)
    {
        parent::__construct();
        $this->projectDir = $projectDir;
        $this->twig = $twig;
        $this->filesystem = $filesystem;

    }

    /**
     * Demande à l'utilisateur de choisir un domaine.
     */
    protected function askDomain(SymfonyStyle $io): string
    {
        $domains = [];
        $files   = (new Finder())->in("{$this->projectDir}/src/Domain")->depth(0)->directories();
        foreach ($files as $file) {
            $domains[] = $file->getBasename();
        }
        $q = new Question('Sélectionner un domaine');
        $q->setAutocompleterValues($domains);

        return $io->askQuestion($q);
    }
    protected function askAttributes(SymfonyStyle $io, $domain, $entity):array
    {
        return $this->getProperties($domain, $entity);
    }
    protected function askEntity(SymfonyStyle $io, string $domain): string
    {
        $finder= new Finder();
        if (!$this->filesystem->exists("{$this->projectDir}/src/Domain/{$domain}")) {
            $question = new Question('domain name not found Do you Create '.self::YES.'/'.self::NO.'?');
            $reponse  = $io->askQuestion($question);
            if (self::NO === mb_strtoupper($reponse)) {
                exit();
            }
            $this->filesystem->mkdir("{$this->projectDir}/src/Domain/{$domain}");
        }
        if (!$this->filesystem->exists("{$this->projectDir}/src/Domain/{$domain}/Entity")) {
            $this->filesystem->mkdir("{$this->projectDir}/src/Domain/{$domain}/Entity");
        }
        $files   = $finder->in("{$this->projectDir}/src/Domain/{$domain}/Entity");
        $entities = [];
        /** @var SplFileInfo $file */
        foreach ($files as $file) {
            $entities[] = str_replace('.php', '', $file->getBasename());
        }
        $q = new Question('Creee ou Sélectionner une entity');
        $q->setAutocompleterValues($entities);

        return $io->askQuestion($q);
    }
    protected function createController($io, $domain, $entity)
    {
        $output  = $this->projectDir.'/src/Http/Controller/'.$entity.'/';
        $paths = [
           ['file' => 'index', 'name' => $entity, 'class' => $entity, 'route' => "/".strtolower($entity), 'route_name' => strtolower($entity), 'output' => $output.$entity.'Controller.php', 'view' => $domain.'/'.$this->slugify($entity).'/'.'index.html.twig'],
           ['file' => 'create', 'name' => $entity, 'class' => 'Create'.$entity, 'route' => "/".strtolower($entity).'/create', 'route_name' => strtolower($entity).'_create', 'output' => $output.'Create'.$entity.'Controller.php', 'view' => $domain.'/'.$this->slugify($entity).'/'.'create.html.twig'],
           ['file' => 'update', 'name' => $entity, 'class' => 'Update'.$entity, 'route' => "/".strtolower($entity).'/update/{id}', 'route_name' => strtolower($entity).'_update', 'output' => $output.'Update'.$entity.'Controller.php', 'view' => $domain.'/'.$this->slugify($entity).'/'.'edit.html.twig'],
        ];
        $basePath = $this->projectDir.'/src/Http/Controller/'.$entity;
        if (!$this->filesystem->exists($basePath)) {
            $this->filesystem->mkdir($basePath);
        }
        foreach ($paths as $path) {
            $params = [
                'namespace' => $path['class'],
                'class_name' => $path['class'].'Controller',
                'route' => $path['route'],
                'route_name' => $path['route_name'],
                'domain' => $domain,
                'view' => $path['view'],
                'name' => $path['name'],
                'route_index' => "admin_".strtolower($entity),
                'route_new' => "admin_".strtolower($entity).'_create',
            ];
            $this->createFile('controller/'.$path['file'].'.controller', $params, $path['output']);
        }
    }
    protected function createButtonOption($io, $domain, $entity)
    {
        $params = [
           'class' => $entity,
           "type" => strtoupper($entity),
        ];
        $this->createFile("datatable/type.datatable", $params, $this->projectDir.'/src/Core/Datatable/Option/'.$entity.'BuildOption.php');
    }
    protected function createTemplate($io, $domain, $entity, $fields)
    {
        $paths = [
           ['template' => 'index'],
           ['template' => '_form'],
           ['template' => 'create'],
           ['template' => 'edit']
        ];
        $basePath = $this->projectDir.'/templates/'.$domain.'/'.$this->slugify($entity);
        if (!$this->filesystem->exists($basePath)) {
            $this->filesystem->mkdir($basePath);
        }
        foreach ($paths as $path) {
            $params = [
                'label' => $entity,
                "id_table" => $this->slugify($entity)."_table",
                "fields" => $fields,
                "domain" => $domain,
                "entity" => $this->slugify($entity),
                'route_index' => "admin_".strtolower($entity),
                'route_new' => "admin_".strtolower($entity).'_create',
            ];
            $output  = $basePath.'/'.$path['template'];
            $this->createFile("views/".$path['template'].".html", $params, $output.'.html.twig');
        }
    }
    protected function createFormType($io, $domain, $entity, $fields)
    {

        $params = [
           'domain' => $domain,
           "entity" => $entity,
           "fields" => $fields,
        ];
        $basePath = $this->projectDir.'/src/Domain/'.$domain.'/Form';
        $this->createFile("form/FormType.php", $params, $basePath.'/'.$entity.'Type.php');
    }
    protected function creatJSFile($io, $domain, $entity, $fields):void
    {
        $paths = [
            ['template' => 'entity.component', 'output' => $entity.'.component.ts'],
            ['template' => 'entity.service', 'output' => $entity.'.service.ts'],
            ['template' => 'index', 'output' => 'index.ts'],

        ];
        $basePath = $this->projectDir.'/assets/Domain/'.ucfirst($entity);

        if (!$this->filesystem->exists($basePath)) {
            $this->filesystem->mkdir($basePath);
        }
        foreach ($paths as $path) {
            $params = [
                'entity' => $entity,
                "name" => strtolower($entity),
                'id_table'=>$this->slugify($entity),
                "fields" => $fields,
            ];
            $this->createFile("js/".$path['template'], $params, $basePath.'/'.$path['output']);
        }
    }
    protected function verfiyCrud(SymfonyStyle $io,string $domain,string $entity){
        $controllerPath = $this->projectDir.'/src/Http/Controller/'.$entity;
        if (!$this->filesystem->exists($controllerPath)){
            return true;
        }
        if ((new Finder())->in($controllerPath)->depth(0)->count()>0){
            $io->error("le crud est deja crée");
            $qs = new Question('Voulez-vous  régénérer le crud '.self::YES.'/'.mb_strtoupper(self::NO).'?');
            $reponse  = $io->askQuestion($qs);
            if (self::YES === mb_strtoupper($reponse)) {
                return true;
            }
            return  false;
        }
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
    function slugify($str)
    {
        $strings = preg_split('/(?=[A-Z])/', $str);
        array_shift($strings);
        $string = "";
        foreach ($strings as $key => $s) {
            $separteur = (count($strings)-1 > $key)?'_':'';
            $string .= strtolower($s).$separteur;
        }

        return $string;
    }
    protected function getProperties(string $domain, string $entity): array
    {
        $reflectionExtractor = new ReflectionExtractor();
     /*   $x= $reflectionExtractor->getProperties("App\\Domain\\".$domain."\\Entity\\".$entity);
        foreach($x as $i){
           dump($reflectionExtractor->getTypes("App\\Domain\\".$domain."\\Entity\\".$entity,$i));
        }
        dd(
           $x
        );
        */
        return $reflectionExtractor->getProperties("App\\Domain\\".$domain."\\Entity\\".$entity);
    }
}
