<?php

declare(strict_types=1);

namespace App\Services\Configuration;

use Psr\Container\ContainerInterface;

interface ConfigurationInterface extends ContainerInterface
{
    public function get($path, $default = null);

    public function set($path, $value);
}
