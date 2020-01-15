<?php

declare(strict_types=1);

namespace App\Services\Configuration;

class ConfigurationService implements ConfigurationInterface
{
    private const UNIQUE_VALUE = 'djn8jn21';
    private array $data = [];
    private string $dirname = __DIR__ . '/../../../config/';

    public function __construct(string $dirname = null)
    {
        $this->dirname = $dirname ?? $this->dirname;
    }

    public function get($key, $default = null)
    {
        $paths = explode('.', $key);
        $dirname = $this->dirname;

        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        $data = null;

        foreach ($paths as $path) {
            if (is_array($data)) {
                if (array_key_exists($path, $data)) {
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

    public function has($key): bool
    {
        return $this->get($key, self::UNIQUE_VALUE) !== self::UNIQUE_VALUE;
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }
}
