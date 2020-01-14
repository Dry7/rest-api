<?php

declare(strict_types=1);

namespace App\Services\Configuration;

class ConfigurationService implements ConfigurationInterface
{
    public function get($key, $default = null)
    {
        $paths = explode('.', $key);
        $dirname = __DIR__ . '/../../../config/';

        $data = null;

        foreach ($paths as $path) {
            if (is_array($data)) {
                if (isset($data[$path])) {
                    $data = &$data[$path];
                } else {
                    return $default;
                }
            } elseif (is_file($dirname . $path . '.php')) {
                $data = require $dirname . $path . '.php';
            } elseif (is_dir($dirname . $path)) {
                $dirname .= $path . '/';
            } else {
                return $default;
            }
        }

        return $data;
    }

    public function has($id)
    {
    }

    public function set($path, $value)
    {
    }
}
