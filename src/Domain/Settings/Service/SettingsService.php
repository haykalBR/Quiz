<?php
namespace App\Domain\Settings\Service;
use App\Domain\Settings\Repository\SettingsRepository;
use Doctrine\ORM\EntityManagerInterface;

class SettingsService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var SettingsRepository
     */
    private SettingsRepository $settingsRepository;
    //A Editer meme code a repeter
    public function __construct(EntityManagerInterface $manager,SettingsRepository $settingsRepository)
    {
        $this->manager = $manager;
        $this->settingsRepository = $settingsRepository;
    }


    public function all($general,$mail,$security){
        $this->generalSettings($general);
        $this->mailSettings($mail);
        $this->securitySettings($security);
    }
    private function securitySettings($security){
        foreach ( $security as $key=>$item){
            $setting= $this->settingsRepository->findOneBy(array('theKey'=>$key));
            $setting->setTheValue($item);
            $this->manager->flush();
        }
    }
    private function generalSettings(array $general){
        foreach ( $general as $key=>$item){
            $setting= $this->settingsRepository->findOneBy(array('theKey'=>$key));
            $setting->setTheValue($item);
            $this->manager->flush();
        }
    }
    private function mailSettings(array $mail){
        foreach ( $mail as $key=>$item){
            $setting= $this->settingsRepository->findOneBy(array('theKey'=>$key));
            $setting->setTheValue($item);
            $this->manager->flush();
        }
    }
}