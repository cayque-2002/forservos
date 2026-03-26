<?php

namespace Src\Core;

use ReflectionClass;

class Container
{
    private static array $bindings = [
        \Src\Domain\Repositories\IUsuarioRepository::class
            => \Src\Infrastructure\Repositories\UsuarioRepository::class
    ];

    public static function resolve($class)
    {
        if (isset(self::$bindings[$class])) {
            $class = self::$bindings[$class];
        }

        $reflection = new ReflectionClass($class);

        if (!$reflection->getConstructor()) {
            return new $class();
        }

        $dependencies = [];

        foreach ($reflection->getConstructor()->getParameters() as $param) {
            $type = $param->getType();

            $dependencies[] = self::resolve($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}

?>