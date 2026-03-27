<?php

namespace Src\Domain\Repositories;

interface IClienteRepository
{
    public function create(string $nomeCliente, string $cpf, int $situacaoClienteId, int $enderecoId, int $numeroEndereco, ?string $complementoCliente): int;
    public function list(): array;
    public function findById(int $id): ?array;
    public function findByCpf(string $cpf): ?array;
    public function update(int $id, string $nomeCliente, string $cpf, int $situacaoClienteId, int $enderecoId, int $numeroEndereco, ?string $complementoCliente): void;
    public function delete(int $id): void;
}

?>