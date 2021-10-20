<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 13/10/2021
 * Time: 16:39
 */
namespace App\Core\Twig;
use App\Domain\Settings\Repository\SettingsRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class SettingsExtension extends AbstractExtension implements GlobalsInterface
{

    /**
     * var Environment $twig.
     */
    private Environment $twig;
    /**
     * @var SettingsRepository
     */
    private SettingsRepository $settingsRepository;


    public function __construct(Environment $twig,SettingsRepository $settingsRepository)
    {
        $this->twig = $twig;

        $this->settingsRepository = $settingsRepository;
    }
    public function getGlobals(): array
    {
        $settings = $this->settingsRepository->findAll();
        $result= [];
        foreach ($settings as $setting) {
            $result[$setting->getTheKey()] = $setting->getTheValue();
        }
        return array(
            'next'=> $result,
        );
    }
    public function getName():string{
        return 'settings_extension';
    }
}