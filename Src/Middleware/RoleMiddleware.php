<?php

namespace Src\Middleware;

use Src\Core\Request;

class RoleMiddleware
{
    public static function handle(array $roles)
    {
        $user = Request::user();

        if (!$user) {
            self::abort(401, "Usuário não autenticado");
        }

        if (!in_array($user->role, $roles)) {
            self::abort(403, "Acesso negado");
        }
    }

    private static function abort($code, $message)
    {
        http_response_code($code);
        echo json_encode(["error" => $message]);
        exit;
    }
}

?>