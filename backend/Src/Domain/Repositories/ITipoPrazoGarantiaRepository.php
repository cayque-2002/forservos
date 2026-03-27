<?php

namespace Src\Domain\Repositories;

interface ITipoPrazoGarantiaRepository
{
    public function create(string $descricaoPrazo): void;
    public function list(): array;
    public function findById(int $id): ?array;
    public function update(int $id, string $descricaoPrazo): void;
    public function delete(int $id): void;
}

?>