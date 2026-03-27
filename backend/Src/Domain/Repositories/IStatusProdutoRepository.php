<?php

namespace Src\Domain\Repositories;

interface IStatusProdutoRepository
{
    public function create(string $descricaoStatus): void;
    public function list(): array;
    public function findById(int $id): ?array;
    public function update(int $id, string $descricaoStatus): void;
    public function delete(int $id): void;
}

?>