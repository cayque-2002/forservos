<?php

namespace Src\Domain\Repositories;

interface IUsuarioRepository
{
    public function create(
        string $nome,
        string $email,
        string $senha,
        int $roleid
    ): void;

    public function findByEmail(string $email): ?array;

    public function findById(int $id): ?array;

    public function list(): array;

    public function update(int $id, string $nome, string $email, int $roleId, bool $ativo): void;

    public function delete(int $id): void;  
}

?>