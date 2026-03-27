<?php

namespace Src\Controllers;

use Src\Services\CidadeService;
use Src\Core\Request;
use Src\Core\Response;
use Src\Core\HttpException;

class CidadeController
{
    private CidadeService $service;

    public function __construct(CidadeService $service)
    {
        $this->service = $service;
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($data['nomeCidade']) ||
            !isset($data['estadoId'])
        ) {
            Response::error("Dados obrigatórios não informados", 400);
            return;
        }

        $this->service->create(
            $data['nomeCidade'],
            (int)$data['estadoId']
        );

        Response::success([
            "message" => "Cidade criada com sucesso"
        ], 201);
    }

    public function list()
    {
        $cidade = $this->service->list();

        Response::success($cidade);
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (
            !isset($data['id']) ||
            !isset($data['nomeCidade']) ||
            !isset($data['estadoId']) 
        ) {
            throw new HttpException("Dados obrigatórios não informados", 400);
        }

        $this->service->update(
            (int)$data['id'],
            $data['nomeCidade'],
            (int)$data['estadoId']
        );

        Response::success([
            "message" => "Cidade atualizada com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            throw new HttpException("Id da cidade não informada", 400);
        }

        $this->service->delete((int)$data['id']);

        Response::success([
            "message" => "Cidade removida com sucesso"
        ]);
    }
}