<?php
namespace Infrastructure\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig\Extensions\TextExtension;
use Twig\Extensions\DateExtension;

class TwigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $settings = $container['settings']['twig'];

        $twig = new Twig($settings['path'], $settings['settings']);
        $twig->addExtension(new TwigExtension(
            $container->router,
            $container->request->getUri()
        ));
        $twig->addExtension(new TextExtension);
        $twig->addExtension(new DateExtension);

        $container['view'] = function () use ($twig) {
            return $twig;
        };

        $container['twig'] = $container['view']; // to show twig errors
    }
}
