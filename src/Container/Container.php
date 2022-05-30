<?php

namespace Remils\Rufy\Container;

use ReflectionClass;
use Remils\Rufy\Container\Contracts\ServiceProvider;
use Remils\Rufy\Container\Exceptions\ServiceNotFoundException;

class Container implements \Remils\Rufy\Container\Contracts\Container
{
    protected array $services = [];

    public function __construct(array $serviceProviders = [])
    {
        $this->registerServices($serviceProviders);
    }

    public function get(string $name)
    {
        if ($this->has($name)) {
            return $this->services[$name];
        }

        throw new ServiceNotFoundException($name);
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->services);
    }

    protected function registerServices(array $serviceProviders): void
    {
        foreach ($serviceProviders as $serviceProvider) {
            $this->registerService((new ReflectionClass($serviceProvider))->newInstance());
        }
    }

    protected function registerService(ServiceProvider $serviceProvider): void
    {
        $this->services[$serviceProvider->name()] = $serviceProvider->newInstance($this);
    }
}
