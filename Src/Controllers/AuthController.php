<?php

namespace Src\Controllers;

use Src\Services\AuthService;

class AuthController
{
    public function login()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $email = $data['email'] ?? '';
        $senha = $data['senha'] ?? '';

        try {
            $service = new AuthService();
            $token = $service->login($email, $senha);

            echo json_encode([
                'token' => $token
            ]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode([
                'error' => $e->getMessage()
            ]);
        }
    }
}