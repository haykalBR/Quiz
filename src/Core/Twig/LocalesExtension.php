<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 22/10/2021
 * Time: 10:05
 */

namespace App\Core\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Intl\Locales;

class LocalesExtension extends  AbstractExtension
{
    private $localeCodes;
    private $locales;

    public function __construct(string $locales)
    {
        $localeCodes = explode('|', $locales);
        sort($localeCodes);
        $this->localeCodes = $localeCodes;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('locales', [$this, 'getLocales']),
        ];
    }


    public function getLocales(): array
    {
        if (null !== $this->locales) {
            return $this->locales;
        }

        $this->locales = [];
        foreach ($this->localeCodes as $localeCode) {
            $this->locales[] = ['code' => $localeCode, 'name' => Locales::getName($localeCode, $localeCode)];
        }

        return $this->locales;
    }
}