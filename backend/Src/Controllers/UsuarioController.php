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
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($data['nome']) ||
            !isset($data['email']) ||
            !isset($data['senha']) ||
            !isset($data['roleId'])
        ) {
            Response::error("Dados obrigatórios não informados", 400);
            return;
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

    public function list()
    {
        $usuarios = $this->service->list();

        Response::success($usuarios);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($data['id']) ||
            !isset($data['nome']) ||
            !isset($data['email']) ||
            !isset($data['roleId']) ||
            !isset($data['ativo'])
        ) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update(
            (int)$data['id'],
            $data['nome'],
            $data['email'],
            (int)$data['roleId'],
            (bool)$data['ativo']
        );

        Response::success([
            "message" => "Usuário atualizado com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id do usuário não informado", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Usuário removido com sucesso"
        ]);
    }
}