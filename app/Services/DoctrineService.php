<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Configuration\ConfigurationInterface;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Finder\Finder;

class DoctrineService
{
    private ConfigurationInterface $config;

    public function __construct(ConfigurationInterface $config)
    {
        $this->config = $config;
    }

    public function build()
    {
        $finder = new Finder();
        $finder->in('../app/');

        return EntityManager::create($this->config->get('database'), $this->buildConfig());
    }

    private function buildConfig(): Configuration
    {
        return Setup::createAnnotationMetadataConfiguration([__DIR__ . '/../../app/Entities'], true);
    }
}
