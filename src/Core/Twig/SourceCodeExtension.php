<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 21/10/2021
 * Time: 10:09
 */

namespace App\Core\Twig;
use Twig\Extension\AbstractExtension;
use function Symfony\Component\String\u;
use Twig\Environment;
use Twig\TemplateWrapper;
use Twig\TwigFunction;
class SourceCodeExtension extends AbstractExtension
{
    private $controller;

    public function setController(?callable $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('show_source_code', [$this, 'showSourceCode'], ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    /**
     * @param string|TemplateWrapper|array $template
     */
    public function showSourceCode(Environment $twig, $template): string
    {
        return $twig->render('debug/source_code.html.twig', [
            'controller' => $this->getController(),
            'template' => $this->getTemplateSource($twig->resolveTemplate($template)),
        ]);
    }

    private function getController(): ?array
    {
        // this happens for example for exceptions (404 errors, etc.)
        if (null === $this->controller) {
            return null;
        }

        $method = $this->getCallableReflector($this->controller);

        $classCode = file($method->getFileName());
        $methodCode = \array_slice($classCode, $method->getStartLine() - 1, $method->getEndLine() - $method->getStartLine() + 1);
        $controllerCode = '    '.$method->getDocComment()."\n".implode('', $methodCode);

        return [
            'file_path' => $method->getFileName(),
            'starting_line' => $method->getStartLine(),
            'source_code' => $this->unindentCode($controllerCode),
        ];
    }

    /**
     * Gets a reflector for a callable.
     *
     * This logic is copied from Symfony\Component\HttpKernel\Controller\ControllerResolver::getArguments
     */
    private function getCallableReflector(callable $callable): \ReflectionFunctionAbstract
    {
        if (\is_array($callable)) {
            return new \ReflectionMethod($callable[0], $callable[1]);
        }

        if (\is_object($callable) && !$callable instanceof \Closure) {
            $r = new \ReflectionObject($callable);

            return $r->getMethod('__invoke');
        }

        return new \ReflectionFunction($callable);
    }

    private function getTemplateSource(TemplateWrapper $template): array
    {
        $templateSource = $template->getSourceContext();
        return [
            'file_path' => $templateSource->getPath(),
            'starting_line' => 1,
            'source_code' => $templateSource->getCode(),
        ];
    }
    private function unindentCode(string $code): string
    {
        $codeLines = u($code)->split("\n");

        $indentedOrBlankLines = array_filter($codeLines, static function ($lineOfCode) {
            return u($lineOfCode)->isEmpty() || u($lineOfCode)->startsWith('    ');
        });

        $codeIsIndented = \count($indentedOrBlankLines) === \count($codeLines);
        if ($codeIsIndented) {
            $unindentedLines = array_map(static function ($lineOfCode) {
                return u($lineOfCode)->after('    ');
            }, $codeLines);
            $code = u("\n")->join($unindentedLines)->toString();
        }

        return $code;
    }
}