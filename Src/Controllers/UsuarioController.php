<?php

namespace Src\Controllers;

use Src\Services\UsuarioService;
use Src\Core\Request;
use Src\Core\Response;
use Src\Core\HttpException;

class UsuarioController
{
    private UsuarioService $service;

    public function __construct(UsuarioService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        $user = Request::user(); // Validação Middleware

        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($data['nome']) ||
            !isset($data['email']) ||
            !isset($data['senha']) ||
            !isset($data['roleId'])
        ) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->create(
            $data['nome'],
            $data['email'],
            $data['senha'],
            (int)$data['roleId']
        );

        Response::success([
            "message" => "Usuário criado com sucesso"
        ], 201);
    }
}