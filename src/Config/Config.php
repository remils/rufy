<?php

namespace Remils\Rufy\Config;

use Throwable;

final class Config
{
    protected array $config = [];

    public function __construct(string $path)
    {
        $this->boot($path);
    }

    protected function boot(string $path): void
    {
        $content = file_get_contents($path);

        preg_match_all('/^([A-Z\_]{1,})\=(.*)$/m', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $matche) {
            try {
                $key   = $matche[1];
                $value = json_decode($matche[2], true, 512, JSON_THROW_ON_ERROR);
            } catch (Throwable $exception) {
                throw new ConfigException('Decoding error "' . $key . '" in the config.');
            }

            if ($this->has($key)) {
                throw new ConfigException('Config "' . $key . '" already exists.');
            }

            $this->config[$key] = $value;
        }
    }

    public function get(string $key): mixed
    {
        if ($this->has($key)) {
            return $this->config[$key];
        }

        throw new ConfigException('Config "' . $key . '" not found.');
    }

    protected function has(string $key): bool
    {
        return array_key_exists($key, $this->config);
    }
}
