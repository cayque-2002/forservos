<?php

namespace Src\Domain\Repositories;

interface IEnderecoRepository
{
    public function create(string $logradouro, string $bairro, string $cep, int $cidadeId, ?string $complementoEndereco): int;
    public function list(): array;
    public function findById(int $id): ?array;
    public function update(int $id, string $logradouro, string $bairro, string $cep, int $cidadeId, ?string $complementoEndereco): void;
    public function delete(int $id): void;
}

?>