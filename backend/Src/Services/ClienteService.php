<?php

namespace Src\Services;

use Src\Domain\Entities\Cliente;
use Src\Domain\Repositories\IClienteRepository;
use Src\Core\HttpException;

class ClienteService
{
    public function __construct(private IClienteRepository $repository) {}

    public function create(string $nomeCliente, string $cpf, int $situacaoClienteId, int $enderecoId, int $numeroEndereco, ?string $complementoCliente): int
    {
        if ($this->repository->findByCpf($cpf)) {
            throw new HttpException("Já existe cliente com este CPF", 400);
        }

        $cliente = new Cliente($nomeCliente, $cpf, $situacaoClienteId, $enderecoId, $numeroEndereco, $complementoCliente);

        return $this->repository->create(
            $cliente->getNomeCliente(),
            $cliente->getCpf(),
            $cliente->getSituacaoClienteId(),
            $cliente->getEnderecoId(),
            $cliente->getNumeroEndereco(),
            $cliente->getComplementoCliente()
        );
    }

    public function list(): array
    {
        return $this->repository->list();
    }

    public function update(int $id, string $nomeCliente, string $cpf, int $situacaoClienteId, int $enderecoId, int $numeroEndereco, ?string $complementoCliente): void
    {
        $clienteAtual = $this->repository->findById($id);

        if (!$clienteAtual) {
            throw new HttpException("Cliente não encontrado", 404);
        }

        $clienteComMesmoCpf = $this->repository->findByCpf($cpf);
        if ($clienteComMesmoCpf && (int)$clienteComMesmoCpf['id'] !== $id) {
            throw new HttpException("Já existe cliente com este CPF", 400);
        }

        $cliente = new Cliente($nomeCliente, $cpf, $situacaoClienteId, $enderecoId, $numeroEndereco, $complementoCliente);

        $this->repository->update(
            $id,
            $cliente->getNomeCliente(),
            $cliente->getCpf(),
            $cliente->getSituacaoClienteId(),
            $cliente->getEnderecoId(),
            $cliente->getNumeroEndereco(),
            $cliente->getComplementoCliente()
        );
    }

    public function delete(int $id): void
    {
        if (!$this->repository->findById($id)) {
            throw new HttpException("Cliente não encontrado", 404);
        }

        $this->repository->delete($id);
    }
}

?>