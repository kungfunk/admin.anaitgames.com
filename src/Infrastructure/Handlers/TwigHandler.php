<?php
namespace Infrastructure\Handlers;

use Interop\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extensions\TextExtension;
use Twig\Extensions\DateExtension;
use Twig\TwigFunction;

class TwigHandler
{
    public static function handle(ContainerInterface $container)
    {
        $settings = $container['settings']['twig'];

        $twig = new Twig($settings['path'], $settings['settings']);
        $twig->addExtension(new TwigExtension(
            $container->router,
            $container->request->getUri()
        ));
        $twig->addExtension(new TextExtension);
        $twig->addExtension(new DateExtension);
        $twig->getEnvironment()->addGlobal('queryStringParams', $container->request->getQueryParams());
        $twig->getEnvironment()->addFunction(
            new TwigFunction('dump', function ($data) {
                return '<pre>' . print_r($data) . '</pre>';
            })
        );

        return $twig;
    }
}
