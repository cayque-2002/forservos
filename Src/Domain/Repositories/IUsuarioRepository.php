<?php

namespace Src\Domain\Repositories;

interface UsuarioRepositoryInterface
{
    public function create(
        string $nome,
        string $email,
        string $senha,
        int $roleId
    ): void;

    public function findByEmail(string $email): ?array;
}

?>