<?php

namespace Src\Domain\Repositories;

interface IRoleUsuariosRepository
{
    public function create(string $nomeRole): void;
    public function list(): array;
    public function findById(int $id): ?array;
    public function update(int $id, string $nomeRole): void;
    public function delete(int $id): void;
}

?>