<?php

namespace Src\Core;

use ReflectionClass;

class Container
{
    public static function resolve($class)
    {
        $reflection = new ReflectionClass($class);

        // se não tem construtor → instancia direto
        if (!$reflection->getConstructor()) {
            return new $class();
        }

        $constructor = $reflection->getConstructor();
        $parameters = $constructor->getParameters();

        $dependencies = [];

        foreach ($parameters as $param) {

            $type = $param->getType();

            if (!$type) {
                throw new \Exception("Dependência sem tipo em {$class}");
            }

            $dependencies[] = self::resolve($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}

?>