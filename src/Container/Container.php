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
        foreach ($serviceProviders as $serviceProvider) {
            $this->set((new ReflectionClass($serviceProvider))->newInstance());
        }
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

    public function set(ServiceProvider $serviceProvider): self
    {
        $this->services[$serviceProvider->name()] = $serviceProvider->newInstance($this);

        return $this;
    }
}
