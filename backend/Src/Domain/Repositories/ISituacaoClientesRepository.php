<?php

namespace Src\Domain\Repositories;

interface ISituacaoClientesRepository
{
    public function create(string $descricaoSituacao): void;
    public function list(): array;
    public function findById(int $id): ?array;
    public function update(int $id, string $descricaoSituacao): void;
    public function delete(int $id): void;
}

?>