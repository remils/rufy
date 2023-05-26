<?php

namespace Remils\Rufy\View;

abstract class Component
{
    abstract public static function make(array $data = []): ViewNode;
}
