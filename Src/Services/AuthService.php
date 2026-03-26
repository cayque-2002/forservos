<?php

namespace Src\Services;

use Src\Repositories\UsuarioRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService
{
    private UsuarioRepository $repo;
    private string $secret;

    public function __construct()
    {
        $this->repo = new UsuarioRepository();
        $this->secret = $_ENV['JWT_SECRET'];
    }

    public function login(string $email, string $senha)
    {
        $user = $this->repo->findByEmail($email);

        if (!$user || !password_verify($senha, $user['senha'])) {
            throw new \Exception("Credenciais inválidas");
        }

        $payload = [
            'iss' => "forservos",
            'sub' => $user['id'],
            'email' => $user['email'],
            'role' => $user['nome_role'],
            'iat' => time(),
            'exp' => time() + 3600
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }
}