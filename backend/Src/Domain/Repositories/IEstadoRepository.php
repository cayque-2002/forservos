<?php

namespace Src\Domain\Repositories;

interface IEstadoRepository
{
    public function create(
        string $nomeEstado,
        string $uf
    ): void;

    public function findByName(string $nomeEstado): ?array;

    public function findById(int $id): ?array;

    public function list(): array;

    public function update(int $id, string $nomeEstado, string $uf): void;

    public function delete(int $id): void;  
}

?>