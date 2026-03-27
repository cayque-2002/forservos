<?php

namespace Src\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Src\Core\HttpException;
use Src\Core\Request;

class AuthMiddleware
{
    public static function handle(): void
    {
        $headers = getallheaders();

        $authorization = $headers['Authorization']
            ?? $headers['authorization']
            ?? null;

        if (!$authorization) {
            throw new HttpException("Token não informado", 401);
        }

        if (!str_starts_with($authorization, 'Bearer ')) {
            throw new HttpException("Token inválido", 401);
        }

        $token = trim(str_replace('Bearer ', '', $authorization));

        try {
            $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
            Request::setUser($decoded);
        } catch (\Throwable $e) {
            throw new HttpException("Token inválido", 401);
        }
    }
}