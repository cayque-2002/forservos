<?php

namespace Src\Controllers;

use Src\Core\HttpException;
use Src\Core\Response;
use Src\Services\ClienteService;

class ClienteController
{
    public function __construct(private ClienteService $service) {}

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $this->service->create(
            $data['nomeCliente'] ?? throw new HttpException("Nome do cliente não informado", 400),
            $data['cpf'] ?? throw new HttpException("CPF não informado", 400),
            (int)($data['situacaoClienteId'] ?? 0),
            (int)($data['enderecoId'] ?? 0),
            (int)($data['numeroEndereco'] ?? 0),
            $data['complementoCliente'] ?? null
        );

        Response::success(["id" => $id, "message" => "Cliente criado com sucesso"], 201);
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
            $data['nomeCliente'] ?? '',
            $data['cpf'] ?? '',
            (int)($data['situacaoClienteId'] ?? 0),
            (int)($data['enderecoId'] ?? 0),
            (int)($data['numeroEndereco'] ?? 0),
            $data['complementoCliente'] ?? null
        );

        Response::success(["message" => "Cliente atualizado com sucesso"]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->service->delete((int)($data['id'] ?? 0));

        Response::success(["message" => "Cliente removido com sucesso"]);
    }
}

?>