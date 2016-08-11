<?php

namespace AppBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Extension\Extension,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\YamlFileLoader,
    Symfony\Component\Config\FileLocator;

/**
 * Class FbMessengerExtension
 *
 * @package AppBundle\DependencyInjection
 *
 * @author Aleksey Tsymbaliuk <alextcy@outlook.com>
 */
class AppExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
