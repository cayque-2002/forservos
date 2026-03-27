<?php

namespace Tests\Fakes;

use Src\Domain\Repositories\IClienteRepository;

class FakeClienteRepository implements IClienteRepository
{
    public array $clientes = [];
    private int $autoIncrement = 1;

    public function create(
        string $nomeCliente,
        string $cpf,
        int $situacaoClienteId,
        int $enderecoId,
        int $numeroEndereco,
        ?string $complementoCliente
    ): int {
        $cliente = [
            'id' => $this->autoIncrement++,
            'nome_cliente' => $nomeCliente,
            'cpf' => $cpf,
            'situacaoclienteid' => $situacaoClienteId,
            'enderecoid' => $enderecoId,
            'numero_endereco' => $numeroEndereco,
            'complemento_cliente' => $complementoCliente
        ];

        $this->clientes[] = $cliente;

        return $cliente['id'];
    }

    public function list(): array
    {
        return $this->clientes;
    }

    public function findById(int $id): ?array
    {
        foreach ($this->clientes as $cliente) {
            if ($cliente['id'] === $id) {
                return $cliente;
            }
        }

        return null;
    }

    public function findByCpf(string $cpf): ?array
    {
        foreach ($this->clientes as $cliente) {
            if ($cliente['cpf'] === $cpf) {
                return $cliente;
            }
        }

        return null;
    }

    public function update(
        int $id,
        string $nomeCliente,
        string $cpf,
        int $situacaoClienteId,
        int $enderecoId,
        int $numeroEndereco,
        ?string $complementoCliente
    ): void {
        foreach ($this->clientes as &$cliente) {
            if ($cliente['id'] === $id) {
                $cliente['nome_cliente'] = $nomeCliente;
                $cliente['cpf'] = $cpf;
                $cliente['situacaoclienteid'] = $situacaoClienteId;
                $cliente['enderecoid'] = $enderecoId;
                $cliente['numero_endereco'] = $numeroEndereco;
                $cliente['complemento_cliente'] = $complementoCliente;
                return;
            }
        }
    }

    public function delete(int $id): void
    {
        $this->clientes = array_values(array_filter(
            $this->clientes,
            fn($cliente) => $cliente['id'] !== $id
        ));
    }
}

?>