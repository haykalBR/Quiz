<?php
namespace App\Http\Controller\Settings;
use App\Domain\Settings\Service\SettingsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/settings", name="settings",options = { "expose" = true })
 */
class SettingsController extends  AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    /**
     * @var SettingsService
     */
    private SettingsService $settingsService;

    public function __construct(EntityManagerInterface $manager,SettingsService $settingsService)
    {
        $this->manager = $manager;
        $this->settingsService = $settingsService;
    }
    public function __invoke(Request $request)
    {
        if ($request->isMethod('POST')){
            $general=$request->get('general');
            $mail=$request->get('Mail');
            $security=$request->get('Mail');
            $this->settingsService->all($general,$mail,$security);
            return  $this->redirectToRoute('admin_settings');
        }
       return $this->render('settings/index.html.twig');
    }
}