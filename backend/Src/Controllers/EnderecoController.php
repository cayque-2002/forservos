<?php

namespace Src\Controllers;

use Src\Core\HttpException;
use Src\Core\Response;
use Src\Services\EnderecoService;

class EnderecoController
{
    public function __construct(private EnderecoService $service) {}

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $this->service->create(
            $data['logradouro'] ?? throw new HttpException("Logradouro não informado", 400),
            $data['bairro'] ?? throw new HttpException("Bairro não informado", 400),
            $data['cep'] ?? throw new HttpException("CEP não informado", 400),
            (int)($data['cidadeId'] ?? 0),
            $data['complementoEndereco'] ?? null
        );

        Response::success(["id" => $id, "message" => "Endereço criado com sucesso"], 201);
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
            $data['logradouro'] ?? '',
            $data['bairro'] ?? '',
            $data['cep'] ?? '',
            (int)($data['cidadeId'] ?? 0),
            $data['complementoEndereco'] ?? null
        );

        Response::success(["message" => "Endereço atualizado com sucesso"]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->service->delete((int)($data['id'] ?? 0));

        Response::success(["message" => "Endereço removido com sucesso"]);
    }
}

?>