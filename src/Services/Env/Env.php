<?php

namespace Remils\Rufy\Services\Env;

use Remils\Rufy\Services\Env\Exceptions\FileNotFoundException;

class Env
{
    protected array $environments = [];

    public function get(string $name, $default = null)
    {
        if ($this->has($name)) {
            return $this->environments[$name];
        }

        return $default;
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->environments);
    }

    public function load(string $path)
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }

        $stream = fopen($path, 'r');

        while ($content = fgets($stream)) {
            $content = array_map('trim', explode("=", $content, 2));

            if (!empty($content[0])) {
                list($name, $value) = $content;

                $this->environments[$name] = $value;
            }
        }

        fclose($stream);
    }

    public function toString(string $name, string $default = null): string
    {
        return (string) $this->get($name, $default);
    }

    public function toBoolean(string $name, bool $default = null): bool
    {
        return (bool) $this->get($name, $default);
    }

    public function toInteger(string $name, int $default = null): int
    {
        return (int) $this->get($name, $default);
    }

    public function toFloat(string $name, float $default = null): float
    {
        return (float) $this->get($name, $default);
    }
}
