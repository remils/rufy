<?php

namespace Remils\Rufy\Container;

use ReflectionFunction;

final class Container
{
    protected array $dependencies = [];

    public function bind(string $key, mixed $value): void
    {
        if ($this->has($key)) {
            throw new ContainerException('Dependency "' . $key . '" already exists.');
        }

        if (is_callable($value)) {
            $this->dependencies[$key] = $this->resolve($value);
        } else {
            $this->dependencies[$key] = $value;
        }
    }

    public function get(string $key): mixed
    {
        if ($this->has($key)) {
            return $this->dependencies[$key];
        }

        $this->throwNotFound($key);
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->dependencies);
    }

    public function resolve(callable $callback): mixed
    {
        $args = [];

        $reflectionFunction   = new ReflectionFunction($callback);
        $reflectionParameters = $reflectionFunction->getParameters();

        foreach ($reflectionParameters as $reflectionParameter) {
            $name = $reflectionParameter->getName();
            /** @var ReflectionNamedType|null */
            $type = $reflectionParameter->getType();

            if ($type && !$type->isBuiltin() && $this->has($type->getName())) {
                $args[$name] = $this->get($type->getName());
                continue;
            }

            if ($this->has($name)) {
                $args[$name] = $this->get($name);
                continue;
            }

            if ($reflectionParameter->isOptional()) {
                $args[$name] = $reflectionParameter->getDefaultValue();
                continue;
            }

            $this->throwNotFound($name);
        }

        return $reflectionFunction->invokeArgs($args);
    }

    protected function throwNotFound(string $key): void
    {
        throw new ContainerException('Dependency "' . $key . '" not found.');
    }
}
