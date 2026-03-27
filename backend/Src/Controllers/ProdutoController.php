<?php

namespace Src\Controllers;

use Src\Core\HttpException;
use Src\Core\Response;
use Src\Services\ProdutoService;

class ProdutoController
{
    public function __construct(private ProdutoService $service) {}

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $this->service->create(
            (int)($data['codProduto'] ?? 0),
            $data['descricaoProduto'] ?? throw new HttpException("Descrição do produto não informada", 400),
            (float)($data['valorProduto'] ?? 0),
            (int)($data['statusId'] ?? 0),
            (int)($data['tipoPrazoGarantiaId'] ?? 0),
            (int)($data['tempoGarantia'] ?? 0)
        );

        Response::success(["id" => $id, "message" => "Produto criado com sucesso"], 201);
    }

    public function list()
    {
        Response::success($this->service->list());
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->service->update(
            (int)($data['id'] ?? 0),
            (int)($data['codProduto'] ?? 0),
            $data['descricaoProduto'] ?? '',
            (float)($data['valorProduto'] ?? 0),
            (int)($data['statusId'] ?? 0),
            (int)($data['tipoPrazoGarantiaId'] ?? 0),
            (int)($data['tempoGarantia'] ?? 0)
        );

        Response::success(["message" => "Produto atualizado com sucesso"]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->service->delete((int)($data['id'] ?? 0));

        Response::success(["message" => "Produto removido com sucesso"]);
    }
}

?>