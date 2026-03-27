<?php

namespace Src\Domain\Repositories;

interface ICidadeRepository
{
    public function create(
        string $nomeCidade,
        int $estadoId
    ): void;

    public function findByName(string $nomeCidade): ?array;

    public function findById(int $id): ?array;

    public function list(): array;

    public function update(int $id, string $nomeCidade, int $estadoId): void;

    public function delete(int $id): void;  
}

?>