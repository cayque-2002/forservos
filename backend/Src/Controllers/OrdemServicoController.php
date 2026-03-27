<?php

namespace Src\Controllers;

use Src\Core\HttpException;
use Src\Core\Response;
use Src\Services\OrdemServicoService;

class OrdemServicoController
{
    public function __construct(private OrdemServicoService $service) {}

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['cliente']) || !is_array($data['cliente'])) {
            throw new HttpException("Dados do cliente não informados", 400);
        }

        $id = $this->service->create(
            (int)($data['numOs'] ?? 0),
            (int)($data['produtoId'] ?? 0),
            (int)($data['cidadeId'] ?? 0),
            $data['observacao'] ?? null,
            $data['cliente'],
            (int)($data['situacaoOsId'] ?? 1)
        );

        Response::success([
            "id" => $id,
            "message" => "Ordem de serviço criada com sucesso"
        ], 201);
    }

    public function list()
    {
        Response::success($this->service->list());
    }

    public function dashboardHoje()
    {
        Response::success($this->service->listDashboardHoje());
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->service->update(
            (int)($data['id'] ?? 0),
            (int)($data['numOs'] ?? 0),
            (int)($data['situacaoOsId'] ?? 0),
            (int)($data['clienteId'] ?? 0),
            (int)($data['produtoId'] ?? 0),
            (int)($data['cidadeId'] ?? 0),
            $data['observacao'] ?? null
        );

        Response::success([
            "message" => "Ordem de serviço atualizada com sucesso"
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->service->delete((int)($data['id'] ?? 0));

        Response::success([
            "message" => "Ordem de serviço removida com sucesso"
        ]);
    }
}

?>