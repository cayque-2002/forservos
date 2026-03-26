<?php

namespace Src\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Src\Core\Request;
use Src\Core\HttpException;

throw new HttpException("Token inválido", 401);

class AuthMiddleware
{
    public static function handle()
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            throw new HttpException("Token inválido", 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $key = $_ENV['JWT_SECRET'];

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // 🔥 aqui muda tudo
            Request::setUser($decoded);

        } catch (\Exception $e) {
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