<?php

namespace Src\Services;

use Src\Domain\Repositories\IUsuarioRepository;
use Src\Core\Exceptions\HttpException;
use Firebase\JWT\JWT;

class AuthService
{
    private IUsuarioRepository $repo;
    private string $secret;

    public function __construct(IUsuarioRepository $repo)
    {
        $this->repo = $repo;
        $this->secret = $_ENV['JWT_SECRET'];
    }

    public function login(string $email, string $senha)
    {
        $user = $this->repo->findByEmail($email);
        
        if (!$user) {
            throw new \Src\Core\HttpException("Usuário não encontrado", 404);
        }

        if (!password_verify($senha, $user['senha'])) {
            throw new \Src\Core\HttpException("Credenciais inválidas", 401);
        }

        $payload = [
            'iss' => "forservos",
            'sub' => $user['id'],
            'email' => $user['email'],
            'role' => $user['nome_role'],
            'iat' => time(),
            'exp' => time() + 86400
        ];

        return JWT::encode($payload, $this->secret, 'HS256');
    }
}