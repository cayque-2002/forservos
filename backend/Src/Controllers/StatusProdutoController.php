<?php

namespace Src\Controllers;

use Src\Services\StatusProdutoService;
use Src\Core\Response;
use Src\Core\HttpException;

class StatusProdutoController
{
    private StatusProdutoService $service;

    public function __construct(StatusProdutoService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $statusProduto = $this->service->list();

        Response::success($statusProduto);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['descricaoStatus'])) {
            throw new HttpException("Descrição do status não informado", 400);
        }

        $this->service->create($data['descricaoStatus']);

        Response::success([
            "message" => "Status criado com sucesso"
        ], 201);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || !isset($data['descricaoStatus'])) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update((int)$data['id'], $data['descricaoStatus']);

        Response::success([
            "message" => "Status atualizado com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id do status não informado", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Status removido com sucesso"
        ]);
    }
}

?>