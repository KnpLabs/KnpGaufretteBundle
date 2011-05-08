<?php

namespace Knplabs\Bundle\GaufretteBundle\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function getRootDir()
    {
        return __DIR__.'/Resources';
    }

    public function registerBundles()
    {
        return array(
            new \Knplabs\Bundle\GaufretteBundle\KnplabsGaufretteBundle(),
        );
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/Resources/config/config_'.$this->getEnvironment().'.yml');
    }
}
