<?php

namespace Src\Middleware;

class MiddlewareHandler
{
    public static function handle(array $middlewares)
    {
        foreach ($middlewares as $middleware) {

            // 🔥 separa nome e parâmetro
            $parts = explode(':', $middleware);

            $name = $parts[0];
            $params = isset($parts[1]) ? explode(',', $parts[1]) : [];

            switch ($name) {

                case 'auth':
                    AuthMiddleware::handle();
                    break;

                case 'role':
                    RoleMiddleware::handle($params);
                    break;
            }
        }
    }
}

?>