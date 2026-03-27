<?php

namespace Src\Controllers;

use Src\Services\SituacaoClientesService;
use Src\Core\Response;
use Src\Core\HttpException;

class SituacaoClientesController
{
    private SituacaoClientesService $service;

    public function __construct(SituacaoClientesService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $situacaoClientes = $this->service->list();

        Response::success($situacaoClientes);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['descricaoSituacao'])) {
            throw new HttpException("Descrição da situação não informada", 400);
        }

        $this->service->create($data['descricaoSituacao']);

        Response::success([
            "message" => "Situação criada com sucesso"
        ], 201);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || !isset($data['descricaoSituacao'])) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update((int)$data['id'], $data['descricaoSituacao']);

        Response::success([
            "message" => "Situação atualizada com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id da situação não informada", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Situação removida com sucesso"
        ]);
    }
}

?>