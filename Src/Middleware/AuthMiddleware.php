<?php

namespace Src\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Src\Core\Request;

class AuthMiddleware
{
    public static function handle()
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            self::abort(401, "Token não informado");
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $key = $_ENV['JWT_SECRET'];

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // 🔥 aqui muda tudo
            Request::setUser($decoded);

        } catch (\Exception $e) {
            self::abort(401, "Token inválido");
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