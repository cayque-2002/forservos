<?php

namespace Src\Domain\Repositories;

interface ISituacaoOsRepository
{
    public function create(string $descricaoSituacaoOs): void;
    public function list(): array;
    public function findById(int $id): ?array;
    public function update(int $id, string $descricaoSituacaoOs): void;
    public function delete(int $id): void;
}

?>