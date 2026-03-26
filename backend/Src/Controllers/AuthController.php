<?php

namespace Src\Controllers;

use Src\Services\AuthService;
use Src\Core\Response;
use Src\Core\HttpException;

class AuthController
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $email = $data['email'] ?? '';  
        $senha = $data['senha'] ?? '';

        $token = $this->service->login($email, $senha);

        Response::success([
            "token" => $token
        ]);
    }
}