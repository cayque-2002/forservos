<?php

namespace Src\Controllers;

use Src\Services\RoleUsuariosService;
use Src\Core\Response;
use Src\Core\HttpException;

class RoleUsuariosController
{
    private RoleUsuariosService $service;

    public function __construct(RoleUsuariosService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $roles = $this->service->list();

        Response::success($roles);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['nomeRole'])) {
            throw new HttpException("Nome da role não informado", 400);
        }

        $this->service->create($data['nomeRole']);

        Response::success([
            "message" => "Role criada com sucesso"
        ], 201);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || !isset($data['nomeRole'])) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update((int)$data['id'], $data['nomeRole']);

        Response::success([
            "message" => "Role atualizada com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id da role não informado", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Role removida com sucesso"
        ]);
    }
}

?>