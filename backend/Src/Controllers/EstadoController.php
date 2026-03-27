<?php

namespace Src\Controllers;

use Src\Services\EstadoService;
use Src\Core\Request;
use Src\Core\Response;
use Src\Core\HttpException;

class EstadoController
{
    private EstadoService $service;

    public function __construct(EstadoService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($data['nomeEstado']) ||
            !isset($data['uf'])
        ) {
            Response::error("Dados obrigatórios não informados", 400);
            return;
        }

        $this->service->create(
            $data['nomeEstado'],
            $data['uf']
        );

        Response::success([
            "message" => "Estado criado com sucesso"
        ], 201);
    }

    public function list()
    {
        $estado = $this->service->list();

        Response::success($estado);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($data['id']) ||
            !isset($data['nomeEstado']) ||
            !isset($data['uf'])
        ) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update(
            (int)$data['id'],
            $data['nomeEstado'],
            $data['uf']
        );

        Response::success([
            "message" => "Estado atualizado com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id do estado não informado", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Estado removido com sucesso"
        ]);
    }
}