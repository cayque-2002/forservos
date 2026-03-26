<?php

namespace Src\Controllers;

use Src\Services\UsuarioService;
use Src\Core\Request;

class UsuarioController
{
    private UsuarioService $service;

    public function __construct()
    {
        $this->service = new UsuarioService();
    }

    public function create()
    {
        $user = Request::user();

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            // validação básica
            if (
                !isset($data['nome']) ||
                !isset($data['email']) ||
                !isset($data['senha']) ||
                !isset($data['roleId'])
            ) {
                http_response_code(400);
                echo json_encode([
                    "error" => "Dados obrigatórios não informados"
                ]);
                return;
            }

            $this->service->create(
                $data['nome'],
                $data['email'],
                $data['senha'],
                (int)$data['roleId']
            );

            http_response_code(201);
            echo json_encode([
                "message" => "Usuário criado com sucesso"
            ]);

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode([
                "error" => $e->getMessage()
            ]);
        }
    }
}