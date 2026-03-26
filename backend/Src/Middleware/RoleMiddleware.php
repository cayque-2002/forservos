<?php

namespace Src\Middleware;

use Src\Core\Request;
use Src\Core\HttpException;

class RoleMiddleware
{
    public static function handle(array $roles)
    {
        $user = Request::user();

        if (!$user) {
            throw new HttpException("Token inválido", 401);
        }

        if (!in_array($user->role, $roles)) {
            throw new HttpException("Token inválido", 401);
        }
    }

    // private static function abort($code, $message)
    // {
    //     http_response_code($code);
    //     echo json_encode(["error" => $message]);
    //     exit;
    // }
}

?>