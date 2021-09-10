<?php

/*
 * This file is part of the Symfony package.
 * (c) Fabien Potencier <fabien@symfony.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Core\Twig;

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class MenuExtension extends AbstractExtension
{
    /**
     * var Environment $twig.
     */
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('Navbar_build', [$this, 'navbarBuild'], ['is_safe' => ['html']]),
            new TwigFunction('Menu_build', [$this, 'menuBuild'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Create Navbar page.
     */
    public function navbarBuild(): string
    {
        return $this->twig->render('_layout/_menu/navbar.html.twig', []);
    }

    /**
     * Create Menu page.
     */
    public function menuBuild(): string
    {
        return $this->twig->render('_layout/_menu/menu.html.twig', []);
    }
}
