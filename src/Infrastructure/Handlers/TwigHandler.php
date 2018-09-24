<?php
namespace Infrastructure\Handlers;

use Interop\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extensions\TextExtension;
use Twig\Extensions\DateExtension;
use Twig\TwigFunction;
use Twig_Markup;

class TwigHandler
{
    public static function handle(ContainerInterface $container)
    {
        $settings = $container['settings']['twig'];

        $twig = new Twig($settings['path'], $settings['settings']);
        $twig->addExtension(new TwigExtension(
            $container['router'],
            $container['request']->getUri()
        ));
        $twig->addExtension(new TextExtension);
        $twig->addExtension(new DateExtension);
        $twig->getEnvironment()->addFunction(
            new TwigFunction('path', function ($url, $parameters, $extraParameters = []) {
                $result = $url . '?' . http_build_query(array_merge($parameters, $extraParameters));
                return new Twig_Markup($result, 'utf-8');
            })
        );

        return $twig;
    }
}
