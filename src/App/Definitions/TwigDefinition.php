<?php
namespace App\Definitions;

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extensions\TextExtension;
use Twig\Extensions\DateExtension;

class TwigDefinition extends AbstractContainerDefinition
{
    public function getSettingsKey()
    {
        return 'settings.twig';
    }

    public function __invoke()
    {
        return [
            Twig::class => function (ContainerInterface $container) {
                $settings = $this->getSettings($container);
                $twig = new Twig($settings['path'], $settings['settings']);
                $twig->addExtension(new TwigExtension(
                    $container->get('router'),
                    $container->get('request')->getUri()
                ));
                $twig->addExtension(new TextExtension);
                $twig->addExtension(new DateExtension);

                return $twig;
            }
        ];
    }
}
