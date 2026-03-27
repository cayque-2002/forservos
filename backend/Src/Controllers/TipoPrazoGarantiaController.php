<?php

namespace Src\Controllers;

use Src\Services\TipoPrazoGarantiaService;
use Src\Core\Response;
use Src\Core\HttpException;

class TipoPrazoGarantiaController
{
    private TipoPrazoGarantiaService $service;

    public function __construct(TipoPrazoGarantiaService $service)
    {
        $this->service = $service;
    }

    public function list()
    {
        $tipoPrazoGarantia = $this->service->list();

        Response::success($tipoPrazoGarantia);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['descricaoPrazo'])) {
            throw new HttpException("Descrição do prazo não informado", 400);
        }

        $this->service->create($data['descricaoPrazo']);

        Response::success([
            "message" => "Prazo criado com sucesso"
        ], 201);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id']) || !isset($data['descricaoPrazo'])) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update((int)$data['id'], $data['descricaoPrazo']);

        Response::success([
            "message" => "Prazo atualizado com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id do prazo não informado", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Prazo removido com sucesso"
        ]);
    }
}

?>