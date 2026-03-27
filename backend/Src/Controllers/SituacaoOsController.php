<?php

namespace Src\Controllers;

use Src\Services\SituacaoOsService;
use Src\Core\Response;
use Src\Core\HttpException;

class SituacaoOsController
{
    private SituacaoOsService $service;

    public function __construct(SituacaoOsService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $situacaoOs = $this->service->list();

        Response::success($situacaoOs);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['descricaoSituacaoOs'])) {
            throw new HttpException("Descrição da situação Os não informada", 400);
        }

        $this->service->create($data['descricaoSituacaoOs']);

        Response::success([
            "message" => "Situação Os criada com sucesso"
        ], 201);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || !isset($data['descricaoSituacaoOs'])) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update((int)$data['id'], $data['descricaoSituacaoOs']);

        Response::success([
            "message" => "Situação Os atualizada com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id da situação Os não informada", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Situação Os removida com sucesso"
        ]);
    }
}

?>